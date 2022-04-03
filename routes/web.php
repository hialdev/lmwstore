<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Livewire\Dash\Admin\Bank\Index as BankIndex;
use App\Http\Livewire\Dash\Admin\Banner\Custom;
use App\Http\Livewire\Dash\Admin\Banner\Index as BannerIndex;
use App\Http\Livewire\Dash\Admin\Brand\Index as BrandIndex;
use App\Http\Livewire\Dash\Admin\Category\Index as CategoryIndex;
use App\Http\Livewire\Dash\Admin\Contact\Index as ContactIndex;
use App\Http\Livewire\Dash\Admin\Coupon\Index as CouponIndex;
use App\Http\Livewire\Dash\Admin\Email\Index as EmailIndex;
use App\Http\Livewire\Dash\Admin\Faq\Index as FaqIndex;
use App\Http\Livewire\Dash\Admin\Footer\Link;
use App\Http\Livewire\Dash\Admin\Footer\Section;
use App\Http\Livewire\Dash\Admin\Index as AdminIndex;
use App\Http\Livewire\Dash\Admin\Label\Index as LabelIndex;
use App\Http\Livewire\Dash\Admin\Page\Index as PageIndex;
use App\Http\Livewire\Dash\Admin\Pesanan\Index as PesananIndex;
use App\Http\Livewire\Dash\Admin\Product\Add as ProductAdd;
use App\Http\Livewire\Dash\Admin\Product\Edit as ProductEdit;
use App\Http\Livewire\Dash\Admin\Product\Index as ProductIndex;
use App\Http\Livewire\Dash\Admin\Profile\Index as ProfileIndex;
use App\Http\Livewire\Dash\Admin\Seo\Index as SeoIndex;
use App\Http\Livewire\Dash\Admin\Setting\Index as SettingIndex;
use App\Http\Livewire\Dash\Admin\Users;
use App\Http\Livewire\Dash\Admin\Value\Index as ValueIndex;
use App\Http\Livewire\Invoice;
use App\Http\Livewire\Page\Brand;
use App\Http\Livewire\Page\CartView;
use App\Http\Livewire\Page\Category;
use App\Http\Livewire\Page\Checkout;
use App\Http\Livewire\Page\Contact;
use App\Http\Livewire\Page\Faq;
use App\Http\Livewire\Page\Index;
use App\Http\Livewire\Page\OrderClear;
use App\Http\Livewire\Page\OrderPending;
use App\Http\Livewire\Page\ProductShow;
use App\Http\Livewire\Page\Profile;
use App\Http\Livewire\Page\Shop;
use App\Http\Livewire\Sitemap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',Index::class)->name('home');
Route::redirect('/home','/');
Route::get('/sitemap', Sitemap::class)->name('sitemap');
Route::get('/contact',Contact::class)->name('contact');
Route::get('/faq',Faq::class)->name('faq');
Route::get('/product',Shop::class)->name('product');
Route::get('/product/{slug}',ProductShow::class)->name('product.show');
Route::get('/category/{slug}',Category::class)->name('product.category');
Route::get('/brand/{slug}',Brand::class)->name('product.brand');

Route::group(['middleware' => ['role:user|admin','auth']], function () {
    
    Route::get('/cart',CartView::class)->name('cart');
    Route::get('/invoice',Invoice::class)->name('invoice');
    Route::get('/checkout',Checkout::class)->name('checkout');

    //User Dashboard
    Route::get('/transaksi-pending',OrderPending::class)->name('order.pending');
    Route::get('/transaksi-sukses',OrderClear::class)->name('order.sukses');
    Route::get('/profile',Profile::class)->name('profile');
});

Route::group(['prefix' => 'canting','middleware' => ['role:admin','auth']], function () {
    Route::get('/',AdminIndex::class)->name('dash.index');
    Route::get('/product',ProductIndex::class)->name('dash.product');
    Route::get('/product/add',ProductAdd::class)->name('dash.product.add');
    Route::get('/product/{id}/edit',ProductEdit::class)->name('dash.product.edit');
    Route::get('/category',CategoryIndex::class)->name('dash.category');
    Route::get('/label', LabelIndex::class)->name('dash.label');
    Route::get('/bank', BankIndex::class)->name('dash.bank');
    Route::get('/pesanan', PesananIndex::class)->name('dash.pesanan');
    Route::get('/users', Users::class)->name('dash.users');
    Route::get('/email', EmailIndex::class)->name('dash.email');
    Route::get('/brand', BrandIndex::class)->name('dash.brand');
    Route::get('/coupon', CouponIndex::class)->name('dash.coupon');
    Route::get('/banner', BannerIndex::class)->name('dash.banner');
    Route::get('/banner-custom', Custom::class)->name('dash.banner.custom');
    Route::get('/value', ValueIndex::class)->name('dash.value');
    Route::get('/faq', FaqIndex::class)->name('dash.faq');
    Route::get('/contact', ContactIndex::class)->name('dash.contact');
    Route::redirect('/meta','/page');
    Route::get('/meta/page', PageIndex::class)->name('dash.page');
    Route::get('/meta/seo', SeoIndex::class)->name('dash.seo');
    Route::get('/footer/section', Section::class)->name('dash.footer.section');
    Route::get('/footer/link', Link::class)->name('dash.footer.link');
    Route::get('/profile', ProfileIndex::class)->name('dash.profile');
    Route::get('/pengaturan', SettingIndex::class)->name('dash.pengaturan');
});

//Auth Google
Route::get('/auth/redirect', [LoginController::class,'redirectToProvider']);
Route::get('/auth/callback', [LoginController::class,'handleProviderCallback']);