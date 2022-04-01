<?php

namespace App\Http\Livewire\Page;

use App\Models\Alamat;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Page;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Checkout extends Component
{
    public $kd_unik,$select_alamat,$tanda,$nama_penerima,$no_penerima,$address,$kota,$provinsi,$zip,$cpn_sale;
    public $notes = '',$sum;
    public $listeners = [
        'updateCart' => '$refresh',
    ];
    public function boot()
    {
        $this->coupon();
        $this->seo();
        $alm = Alamat::where('id_user',Auth::user()->id)->latest()->take(1)->first();
        if (isset($alm)) {
            $this->select_alamat = $alm->tanda;
        }
    }

    public function seo()
    {
        $set = Setting::all()->keyBy('key');
        $cart = Cart::where('id_user',Auth::id())->first();
        SEOTools::setTitle('Checkout - LMW Store');
        SEOTools::setDescription($cart->product->brief);
        SEOTools::opengraph()->setUrl(Request::url());
        SEOTools::setCanonical(Request::url());
        SEOTools::opengraph()->addProperty('type', 'page');
        SEOTools::twitter()->setSite('Checkout - LMW Store');
        SEOTools::jsonLd()->addImage(asset('storage'.json_decode($cart->product->image)[0]));
    }

    public function render()
    {
        // $this->seo();
        $data = $this->cartData();
        $cpn = Coupon::where('code',session()->get('coupon'))->first();
        if ($cpn !== null && $this->cpn_sale > $cpn->max) {
            $sum_cpn = $data['total']-$cpn->max;
        }else{
            $sum_cpn = $data['total']-$this->cpn_sale;
        }
        $alamats = Alamat::where('id_user',Auth::user()->id)->get();
        $select = Alamat::where('id_user',Auth::user()->id)->where('tanda',$this->select_alamat)->first();
        
        $pd = PesananDetail::where('created_at',Carbon::today())->get();
        $kd_unik = rand(0,9).rand(1,9).rand(0,9);

        if (count($pd) > 0) {
            foreach ($pd as $pdt) {
                if ($kd_unik !== $pdt->kode_unik) {
                    $this->kd_unik = $kd_unik;
                }
            }
        }else{
            $this->kd_unik = $kd_unik;
        }
        $this->sum = $sum_cpn+$this->kd_unik;
        if ($data['count'] == 0) {
            redirect()->route('product')->with('failed','Anda tidak memiliki product untuk checkout. Silahkan berbelanja terlebih dahulu :D');
        }
        return view('livewire.page.checkout',[
            'alamats' => $alamats,
            'alm' => $select,
            'data' => $data,
            'cpnData' => $cpn,
            'cpn' => $this->cpn_sale,
            'calc' => $this->sum,
            'kd_unik' => $this->kd_unik,
        ]);
    }

    public function addAlamat()
    {
        $uid = Auth::user()->id;
        $alamat = Alamat::create([
            'id_user' => $uid,
            'tanda' => $this->tanda,
            'nama_penerima' => $this->nama_penerima,
            'no_penerima' => $this->no_penerima,
            'address' => $this->address,
            'kota' => $this->kota,
            'provinsi' => $this->provinsi,
            'zip' => $this->zip,
        ]);

        if ($alamat) {
            redirect()->route('checkout')->with('success','Berhasil menambah alamat penerima.');
        }else{
            session()->flash('failed','Gagal menambah alamat penerima.');
        }
    }

    //Mengambil data keranjang
    public function cartData()
    {
        $uid = Auth::id();
        $carts = Cart::where('id_user',$uid)->latest()->get();
        //$cart = Cart::where('id_user',$uid)->latest()->limit(3)->get();
        
        $total = 0;
        foreach ($carts as $cart) {
            $total += ($cart->product->price - $cart->product->price*$cart->product->discount/100)*$cart->qty; 
        }

        $cartData = [
            'data' => $carts,
            'count' => count($carts),
            'total' => $total,
        ];
        return $cartData;
    }

    //Kelola Coupon Form
    public function coupon()
    {
        $copn = session()->get('coupon');
        $cpn = Coupon::where('code',$copn)->first();
        $data = $this->cartData();
        if ($cpn) {
            $coupon = $data['total']*$cpn->discount/100;
            if ($coupon > $cpn->max) {
                $coupon = $cpn->max;
            }
        }else{
            $coupon = 0;
        }
        $this->cpn_sale = $coupon;
    }

    //order
    public function order()
    {
        $inv = 'LMW'.Carbon::now()->format('ymd').rand(0,9).rand(0,9).rand(0,9).rand(0,9).Auth::id();
        $carts = Cart::where('id_user',Auth::user()->id)->get();
        $alamat = Alamat::where('id_user',Auth::user()->id)->where('tanda',$this->select_alamat)->first();
        $pesanan = Pesanan::create([
            'id_user' => Auth::user()->id,
            'id_alamat' => $alamat->id,
            'kode_pesanan' => $inv,
            'note' => $this->notes,
            'coupon' => session()->get('coupon') !== null ? session()->get('coupon') : '-',
            'kode_uniq' => $this->kd_unik,
            'tax' => 0,
            'sum_price' => $this->sum,
        ]);
        if ($pesanan) {
            $pdtl = Pesanan::where('kode_pesanan',$inv)->first();
            foreach ($carts as $cart) {
                PesananDetail::create([
                    'id_pesanan' => $pdtl->id,
                    'id_product' => $cart->product->id,
                    'detail' => $cart->detail,
                    'qty' => $cart->qty,
                ]);
            }
            Cart::where('id_user',Auth::user()->id)->delete();

            session()->put('kode_pesanan',$inv);

            redirect()->route('invoice');
        }
    }
}
