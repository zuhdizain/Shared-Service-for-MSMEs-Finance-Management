<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\AttendController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpiredController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PicketsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TrainingController;
use Illuminate\Routing\Route as RoutingRoute;

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

// Route::get('/', function () {
//     return view('auth/login');
// });

// Authentication route
Route::get('/', [LoginController::class, 'index']);
Route::post('/', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/callCenter', [LoginController::class, 'callCenter']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/ccSubmit', [ViewController::class, 'ccSubmit'])->name('contact.submit');

// ====================================================================================================================================================================
// ====================================================================================================================================================================
// Admin Route
Route::prefix('admin')->middleware(['admin', 'auth'])->group(function () {
    Route::get('/dashboardAdmin', [AdminController::class, 'dashboardAdmin'])->name('dashboardAdmin');
    Route::get('/daftar-perusahaan', [AdminController::class, 'companyList'])->name('hr.companyList');
});

// ====================================================================================================================================================================
// ====================================================================================================================================================================
// HR Route
Route::prefix('hr')->middleware(['hr', 'auth'])->group(function () {

    Route::get('/dashboardHR', [ViewController::class, 'dashboardHR'])->name('dashboardHR');
    Route::get('/myProfile', [ViewController::class, 'profile']);
    Route::get('/editProfile', [ViewController::class, 'editprofile']);

    // Resource route
    Route::resources([
        'employee'   => EmployeeController::class,
        'division'   => DivisionController::class,
        'training'   => TrainingController::class,
        'history'    => HistoryController::class,
        'company'    => CompanyController::class,
        'picket'     => PicketsController::class,
        'absensi'    => AttendController::class,
        'user'       => UserController::class
    ]);

    // Division Extra Route(s)
    Route::get('/emp_division/{id}/pegawai', [DivisionController::class, 'allEmpDvs'])->name('division.allEmpDvs');

    // Pickets Extra Route(s)
    Route::get('/piket/{days}/pegawai', [PicketsController::class, 'allEmpPkc'])->name('picket.allEmp');

    // Attend Extra Route(s)
    Route::get('/cetak-form-pegawai', [AttendController::class, 'cetakAbsen'])->name('absensi.cetak');
    Route::get('/cetak-pegawai-pertanggal/{tglawal}/{tglakhir}', [AttendController::class, 'cetakAbsenPertanggal'])->name('absensi.pertanggal');
});

// ====================================================================================================================================================================
// ====================================================================================================================================================================
// Inventory Route
Route::prefix('supplier')->middleware(['supplier', 'auth'])->group(function () {
    Route::get('/myProfileInven', [ViewController::class, 'profileInven']);
    Route::get('/editProfileInven', [ViewController::class, 'editprofileInven']);
    Route::get('/dashboardInven', [ConfirmController::class, 'index'])->name('dashboardInven');

    Route::resources([
        'good' => GoodController::class
    ]);

    Route::group(['middleware' => ['inven']], function () {
        Route::resources([
            'product' => ProductController::class,
            'out' => OutController::class,
            'retur' => ReturController::class,
            'expired' => ExpiredController::class,
            'confirm' => ConfirmController::class
        ]);


        Route::get('/orderReport', function () {
            return view('Inventory_Apps.inven.orderReport');
        });

        // Inventory Route
        Route::get('/tableProductData', function () {
            return view('Inventory_Apps.inven.tableProductData');
        });

        Route::get('/tableGoodsData', function () {
            return view('Inventory_Apps.inven.tableGoodsData');
        });

        Route::get('/tableOutData', function () {
            return view('Inventory_Apps.inven.tableOutData');
        });
    });
});

// ====================================================================================================================================================================
// ====================================================================================================================================================================
// Sales Route
Route::prefix('sales')->middleware(['sales', 'auth'])->group(function () {
    Route::get('/dashboardSales', [ViewController::class, 'dashboardSales'])->name('dashboardSales');

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('/input', [OrderController::class, 'addOrderpage'])->name('order.addpage');
        Route::post('/input', [OrderController::class, 'addOrder'])->name('order.add');
        Route::get('/edit/{id}', [OrderController::class, 'orderEdit'])->name('order.edit');
        Route::get('/detail/{id}', [OrderController::class, 'orderDetailpage'])->name('order.detailpage');
        Route::get('/get-order-detail/{id}', [OrderController::class, 'getOrderDetail'])->name('order.getOrderDetail');
        Route::post('/update/{id}', [OrderController::class, 'orderUpdate'])->name('order.update');
        Route::get('/delete/{id}', [OrderController::class, 'deleteOrder'])->name('order.delete');
        Route::get('/update-status', [OrderController::class, 'updateStatuspage'])->name('order.editStatuspage');
        Route::get('/update-status-success/{id}', [OrderController::class, 'updateStatusSuccess'])->name('order.updateStatusSuccess');
        Route::get('/update-status-failed/{id}', [OrderController::class, 'updateStatusFailed'])->name('order.updateStatusFailed');
        Route::post('/refund', [OrderController::class, 'orderRefund'])->name('order.refund');
        Route::get('/update-refund-status-success/{id}', [OrderController::class, 'updateRefundStatusSuccess'])->name('order.updateRefundStatusSuccess');
        Route::get('/update-refund-status-failed/{id}', [OrderController::class, 'updateRefundStatusFailed'])->name('order.updateRefundStatusFailed');
        Route::get('/get-all-product', [OrderController::class, 'getAllProduct'])->name('order.getAllProduct');
        Route::post('/order-product', [OrderController::class, 'orderProduct'])->name('order.orderProduct');
        Route::post('/delete-product-order/{id}', [OrderController::class, 'deleteProductOrder'])->name('order.deleteProductOrder');
        Route::post('/increase-quantity/{id}', [OrderController::class, 'increaseQuantity'])->name('order.increaseQuantity');
        Route::post('/decrease-quantity/{id}', [OrderController::class, 'decreaseQuantity'])->name('order.decreaseQuantity');
    });

    Route::prefix('/report')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('report.index');
        Route::post('/report-by-product', [ReportController::class, 'reportByProduct'])->name('report.reportByProduct');
        Route::post('/report-by-customer', [ReportController::class, 'reportByCustomer'])->name('report.reportByCustomer');
        Route::post('/report-by-status', [ReportController::class, 'reportByStatus'])->name('report.reportByStatus');
        Route::post('/report-by-date', [ReportController::class, 'reportByDate'])->name('report.reportByDate');
        Route::get('/riwayat-laporan', [ReportController::class, 'riwayatLaporan'])->name('report.riwayatLaporan');

        Route::prefix('/export')->group(function () {
            Route::get('/report-by-product', [ReportController::class, 'exportReportByProduct'])->name('report.exportReportByProduct');
            Route::get('/report-by-customer', [ReportController::class, 'exportReportByCustomer'])->name('report.exportReportByCustomer');
            Route::get('/report-by-status', [ReportController::class, 'exportReportByStatus'])->name('report.exportReportByStatus');
            Route::get('/report-by-date', [ReportController::class, 'exportReportByDate'])->name('report.exportReportByDate');
        });

        Route::get('download/{id}', [HomeController::class, 'getDownload'])->name('report.download');
    });

    Route::prefix('/customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/add', [CustomerController::class, 'addCustomerpage'])->name('customer.addpage');
        Route::post('/add', [CustomerController::class, 'addCustomer'])->name('customer.add');
        Route::get('/delete/{id}', [CustomerController::class, 'deleteCustomer'])->name('customer.delete');
        Route::get('/{id}', [CustomerController::class, 'customerData'])->name('customer.data');
    });
});

// ====================================================================================================================================================================
// ====================================================================================================================================================================
// Finance Route
Route::prefix('finance')->middleware(['finance', 'auth'])->group(function () {
    Route::get('/dashboardFinance', [ViewController::class, 'dashboardFinance'])->name('dashboardFinance');

    Route::prefix('/manage-finance')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('finance.index');
    });

    Route::prefix('/balance-sheet')->group(function () {
        Route::get('/', [FinanceController::class, 'balanceSheet'])->name('finance.balanceSheet');
        Route::get('/get-balance-sheet/{month}', [FinanceController::class, 'getBalanceSheet'])->name('finance.getBalanceSheet');
        Route::post('/add-balance-sheet', [FinanceController::class, 'addBalanceSheet'])->name('finance.addBalanceSheet');
        Route::post('/update-balance-sheet', [FinanceController::class, 'updateBalanceSheet'])->name('finance.updateBalanceSheet');
        Route::post('/report', [FinanceController::class, 'balanceSheetReport'])->name('finance.balanceSheetReport');
    });

    Route::prefix('/profit-loss')->group(function () {
        Route::get('/', [FinanceController::class, 'profitLoss'])->name('finance.profitLoss');
        Route::get('/get-profit-loss/{month}', [FinanceController::class, 'getProfitLoss'])->name('finance.getProfitLoss');
        Route::get('/get-profit-loss-cogs/{month}', [FinanceController::class, 'getProfitLossCOGS'])->name('finance.getProfitLossCOGS');
        Route::post('/add-profit-loss-cogs', [FinanceController::class, 'addProfitLossCOGS'])->name('finance.addProfitLossCOGS');
        Route::post('/update-profit-loss-cogs', [FinanceController::class, 'updateProfitLossCOGS'])->name('finance.updateProfitLossCOGS');
        Route::get('/get-profit-loss-sse/{month}', [FinanceController::class, 'getProfitLossSSE'])->name('finance.getProfitLossSSE');
        Route::post('/add-profit-loss-sse', [FinanceController::class, 'addProfitLossSSE'])->name('finance.addProfitLossSSE');
        Route::post('/update-profit-loss-sse', [FinanceController::class, 'updateProfitLossSSE'])->name('finance.updateProfitLossSSE');
        Route::get('/get-profit-loss-ga/{month}', [FinanceController::class, 'getProfitLossGA'])->name('finance.getProfitLossGA');
        Route::post('/add-profit-loss-ga', [FinanceController::class, 'addProfitLossGA'])->name('finance.addProfitLossGA');
        Route::post('/update-profit-loss-ga', [FinanceController::class, 'updateProfitLossGA'])->name('finance.updateProfitLossGA');
        Route::post('/report', [FinanceController::class, 'profitLossReport'])->name('finance.profitLossReport');
    });

    Route::prefix('/cash-flow')->group(function () {
        Route::get('/', [FinanceController::class, 'cashFlow'])->name('finance.cashFlow');
        Route::get('/get-cash-flow/{year}', [FinanceController::class, 'getCashFlow'])->name('finance.getCashFlow');
        Route::post('/add-cash-flow', [FinanceController::class, 'addCashFlow'])->name('finance.addCashFlow');
        Route::post('/update-cash-flow', [FinanceController::class, 'updateCashFlow'])->name('finance.updateCashFlow');
        Route::post('/report', [FinanceController::class, 'cashFlowReport'])->name('finance.cashFlowReport');
    });

    Route::prefix('/export')->group(function () {
        Route::get('/balance-sheet', [ReportController::class, 'exportBalanceSheet'])->name('report.exportBalanceSheet');
        Route::get('/profit-loss', [ReportController::class, 'exportProfitLoss'])->name('report.exportProfitLoss');
        Route::get('/cash-flow', [ReportController::class, 'exportCashFlow'])->name('report.exportCashFlow');
    });
});
