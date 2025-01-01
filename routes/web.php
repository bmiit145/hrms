
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Employee_detailsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HolidayConteoller;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamheadController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\BenefitsController;


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

Route::get('/', function () {
    return view('admin_layout.Login');
});

Route::get('sdjdfh/', function () {
    return view('admin_layout.sidebar');
});

Route::get('sdjdfh/', function () {
    return view('User.user_layout.sidebar');
});
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {

        Route::get('/login', [LoginController::class, 'login_form'])->name('login');
        Route::post('/csdds', [LoginController::class, 'Authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => 'admin.auth'], function () {

        Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

        // admin_details 
        Route::get('/over-time', [OvertimeController::class, 'index'])->name('index.overtime');
        Route::post('/over-store', [OvertimeController::class, 'store'])->name('store.overtime');
        Route::post('/over-edit', [OvertimeController::class, 'edit'])->name('edit.overtime');
        Route::post('/over-delete', [OvertimeController::class, 'delete'])->name('delete.overtime');

        Route::get('/benefits-time', [BenefitsController::class, 'index'])->name('index.benefits');
        Route::post('/benefits-store', [BenefitsController::class, 'store'])->name('store.benefits');
        Route::post('/benefits-edit', [BenefitsController::class, 'edit'])->name('edit.benefits');
        Route::post('/benefits-delete', [BenefitsController::class, 'delete'])->name('delete.benefits');



        Route::get('/sidebar', [AdminController::class, 'index']);
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dahsboard');

        Route::get('/get-sales-chart-data', [AdminController::class, 'getSalesChartData'])->name('getSalesChartData');
        Route::get('/get-profit-chart-data', [AdminController::class, 'getProfitChartData'])->name('getProfitChartData');
        Route::get('/receivable-payable-data', [AdminController::class, 'getReceivablePayableData'])->name('getReceivablePayableData');
        Route::get('/pending-payable-data', [AdminController::class, 'getPendingPayableData'])->name('getPendingPayableData');
        Route::get('/income-chart-data', [AdminController::class, 'getIncomeChartData'])->name('getincomeChartData');
        Route::get('/expenses-chart-data', [AdminController::class, 'getExpensesChartData'])->name('getExpensesChartData');
        Route::get('/profit-and-loss-chart-data', [AdminController::class, 'getProfitAndLossChartData'])->name('getProfitAndLossChartData');

        
        Route::get('/client', [AdminController::class, 'Client_view'])->name('admin.Client_view');
        Route::get('/client-income', [AdminController::class, 'Clinetincome'])->name('admin.Clinetincome');
        Route::get('/company-progress', [AdminController::class, 'company_progress'])->name('admin.company_progress');
        Route::post('/Client_store', [AdminController::class, 'Client_store'])->name('admin.Client_store');
        Route::post('/Client_update', [AdminController::class, 'Client_update'])->name('admin.Client_update');
        Route::post('/Client_delete', [AdminController::class, 'Client_delete'])->name('admin.Client_delete');
        Route::post('/saveExpense', [AdminController::class, 'saveExpense'])->name('admin.saveExpense');
        Route::post('/editIncomeData', [AdminController::class, 'editIncomeData'])->name('admin.editIncomeData');
        Route::post('/saveDescription', [AdminController::class, 'saveDescription'])->name('saveDescription');

        Route::get('/festival', [AdminController::class, 'upcoming_festival'])->name('admin.festival');
        Route::post('/festival_store', [AdminController::class, 'festival_store'])->name('admin.festival_store');
        Route::post('/festival_edit', [AdminController::class, 'festival_edit'])->name('admin.festival_edit');
        Route::post('/delete-festival', [AdminController::class, 'deleteFestival'])->name('admin.delete-festival');
        Route::post('/deleteIncomeData', [AdminController::class, 'deleteIncomeData']);


        // Profile Edit
        Route::get('/profile-edit', [AdminController::class, 'profileEdit'])->name('admin.profile.edit');
        Route::post('/profile-update', [AdminController::class, 'profileUpdate'])->name('admin.profile.update');

        // Close Card Route
        Route::get('/close-card',[AdminController::class,'closeCard'])->name('admin.close.card');
        Route::get('/restore-card',[AdminController::class,'restoreCard'])->name('admin.restore.card');


        // emp_add_details

        Route::get('/employee', [Employee_detailsController::class, 'index'])->name('admin.employee');
        Route::get('/employee-create', [Employee_detailsController::class, 'emp_form'])->name('admin.employee.create');
        Route::post('/employee-store', [Employee_detailsController::class, 'form_store'])->name('admin.employee.store');
        Route::get('/employee-edit/{id}', [Employee_detailsController::class, 'employee_edit'])->name('admin.employee.edit');
        Route::post('/employee-update', [Employee_detailsController::class, 'emp_details_edit'])->name('admin.employee.update');
        Route::post('/bcdhygubjh', [Employee_detailsController::class, 'change_passowed'])->name('admin.changepass');
        Route::post('/employee-change-password', [Employee_detailsController::class, 'EmployeeChangePassowed'])->name('admin.EmployeeChangePassowed');
        Route::post('/delete', [Employee_detailsController::class, 'emp_deleted']);
        Route::post('/user_lock', [Employee_detailsController::class, 'user_lock']);

        Route::delete('/delete-emp-document', [Employee_detailsController::class, 'deleteEMPDocument'])->name('admin.delete-emp-document');
        Route::delete('/delete-emp-bank-document', [Employee_detailsController::class, 'deleteBankDocument'])->name('admin.delete.emp.bank.document');
        Route::delete('/delete-emp-profile-document', [Employee_detailsController::class, 'deleteProfileDocument'])->name('admin.delete.emp.profile.document');

        Route::get('/employee-view/{id}', [Employee_detailsController::class, 'admin_employee_view'])->name('admin.employee_view');



        Route::get('/department', [DepartmentController::class, 'department_view'])->name('admin.department');
        Route::post('/nbvhugdai', [DepartmentController::class, 'add_department'])->name('admin.add_department');
        Route::post('/edit_department', [DepartmentController::class, 'edit_department'])->name('admin.edit_department');
        Route::post('/delete_department', [DepartmentController::class, 'delete_department'])->name('admin.delete_department');


        Route::get('/holiday', [HolidayConteoller::class, 'Add_holiday'])->name('admin.holiday');
        Route::post('/holiday_store', [HolidayConteoller::class, 'store'])->name('admin.holiday_store');
        Route::post('/holiday_edit', [HolidayConteoller::class, 'edit'])->name('admin.holiday_edit');
        Route::post('/holidat_delete', [HolidayConteoller::class, 'delete'])->name('admin.holiday_delete');
        Route::get('/xbcghsdfhdgf', [HolidayConteoller::class, 'user_holiday_list']);

        Route::get('/today-attendance', [AttendanceController::class, 'today_blade'])->name('admin.today.attendance');
        Route::post('/attendance_store', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::post('/attendance_update', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::post('/attendance_delete', [AttendanceController::class, 'delete'])->name('attendance.delete');
        Route::get('/attendance-sheet', [AttendanceController::class, 'attendance_sheet'])->name('admin.attendance_sheet');
        Route::get('/leaveRequest', [AttendanceController::class, 'user_leave'])->name('admin.leave.index');
        Route::get('/leave_create', [AttendanceController::class, 'admin_leave'])->name('admin.leave_request_list');
        Route::post('/leave_store', [AttendanceController::class, 'leave_request_store'])->name('admin.leave_request_store');
        Route::post('/leave_edit', [AttendanceController::class, 'edit_leave_request'])->name('admin.edit_leave_request');
        Route::post('/leave_delete_user', [AttendanceController::class, 'delete_leave_request_user'])->name('admin.delete_leave_request_user');
        Route::post('/leave_approved', [AttendanceController::class, 'leave_approved'])->name('admin.leave_approved');
        Route::post('/leave_delete_admin', [AttendanceController::class, 'delete_leave_request_admin'])->name('admin.delete_leave_request_admin');
        Route::post('/storeAdjustment', [AttendanceController::class, 'storeAdjustment'])->name('admin.storeAdjustment');

        // Employee attendance List
        Route::get('/employee-attendance', [AttendanceController::class, 'employeeAttendance'])->name('admin.employee.attendance');

        //salary Slip
        // Route::get('/salary-slip-priview/{id}', [AttendanceController::class, 'salary_priview'])->name('admin.salary_priview');
        Route::get('salary-slip-priview/{id}/{month}/{year}', [AttendanceController::class, 'salary_priview'])->name('admin.salary_priview');
        Route::post('send-salary-slip/{id}/{month}/{year}', [AttendanceController::class, 'sendSalarySlip'])->name('admin.salary_mail_send');
      

        // Cechk Email exists or not
        Route::post('/check-email', [Employee_detailsController::class, 'checkEmail'])->name('admin.checkEmail');

        // Employee Page Access Roue
        Route::post('/employee-page-access', [AdminController::class, 'employeePageAccess'])->name('admin.employee.page.access');


        // Invoice Route
        Route::get('/invoice',[InvoiceController::class,'index'])->name('admin.invoice.index');
        Route::get('/invoice-create/{id?}', [InvoiceController::class, 'create'])->name('admin.invoice.create');
        Route::post('/invoice-store', [InvoiceController::class, 'store'])->name('admin.invoice.store');
        Route::get('/invoice-update/{id}', [InvoiceController::class, 'update'])->name('admin.invoice.update');
        Route::delete('/invoice/delete/{id}', [InvoiceController::class, 'delete'])->name('admin.invoice.delete');  
        Route::get('/invoice/deleted', [InvoiceController::class, 'deletedInvoices'])->name('admin.invoice.deleted');  
        Route::post('invoice/restore/{id}', [InvoiceController::class, 'restore'])->name('admin.invoice.restore');
        Route::get('/invoice/preview/{id}', [InvoiceController::class, 'preview'])->name('admin.invoices.preview');
        Route::get('/invoice/{invoice}/download', [InvoiceController::class, 'downloadInvoice'])->name('admin.invoice.download');
        Route::get('invoice-pdf/{id}', [InvoiceController::class, 'download']);



        //Project Route
        Route::get('/project', [ProjectController::class, 'index'])->name('admin.project');
        Route::post('/project-store', [ProjectController::class, 'store'])->name('admin.project.store');
        Route::post('/project-edit', [ProjectController::class, 'edit'])->name('admin.project.edit');
        Route::get('/project-delete',[ProjectController::class,'delete'])->name('admin.project.delete');

        // Project Payment Route
        Route::post('/project-payment',[PaymentController::class,'projectPayment'])->name('admin.project.payment');
        Route::get('/project/payment-details', [PaymentController::class, 'getPaymentDetails'])->name('admin.project.payment.detail');
        Route::post('/project/payment-update', [PaymentController::class, 'updatePayment'])->name('admin.project.payment.update');
        Route::post('/project/payment-delete', [PaymentController::class, 'deletePayment'])->name('admin.project.payment.delete');

        // Admin List Route
        Route::get('/admin-list',[AdminController::class,'adminList'])->name('admin.admin.list');

    });
});

Route::group(['prefix' => 'hr'], function () {
    Route::group(['middleware' => 'admin.auth'], function () {
        
        Route::get('/dashboard', [HRController::class, 'dashboard'])->name('hr.dahsboard');

        Route::get('/hr-company_progress', [HRController::class, 'company_progress'])->name('hr.company_progress');
        Route::get('/hr-project_index', [HRController::class, 'project_index'])->name('hr.project_index');
        Route::get('/hr-Client_view', [HRController::class, 'Client_view'])->name('hr.Client_view');
        Route::get('/hr-Clinetincome', [HRController::class, 'Clinetincome'])->name('hr.Clinetincome');

        Route::get('/department_view', [HRController::class, 'department_view'])->name('hr.department_view');
        Route::get('/salary_priview/{id}/{month}/{year}', [HRController::class, 'salary_priview'])->name('hr.salary_priview');

        Route::get('/employee', [HRController::class, 'hr_emp_index'])->name('hr.employee');
        Route::get('/employee-create', [HRController::class, 'hr_emp_form'])->name('hr.create');
        Route::post('/employee-store', [HRController::class, 'hr_emp_form_store'])->name('hr.store');
        Route::get('/employee-edit/{id}', [HRController::class, 'hr_employee_edit'])->name('hr.edit');
        Route::post('/employee-update', [HRController::class, 'hr_emp_details_edit'])->name('hr.update');
        Route::POST('/change_password', [HRController::class, 'hr_change_password'])->name('hr.change_password');
        Route::post('/delete', [HRController::class, 'hr_emp_deleted']);
        Route::post('/user_lock', [HRController::class, 'hr_user_lock']);
        Route::post('/check-email', [HRController::class, 'hr_checkEmail'])->name('hr.checkEmail');
        Route::delete('/delete-emp-document', [HRController::class, 'hr_deleteEMPDocument'])->name('hr.delete-emp-document');
        Route::delete('/delete-emp-bank-document', [HRController::class, 'hr_deleteBankDocument'])->name('hr.delete.emp.bank.document');
        Route::delete('/delete-emp-profile-document', [HRController::class, 'hr_deleteProfileDocument'])->name('hr.delete.emp.profile.document');
        Route::get('/employee-view/{id}', [HRController::class, 'hr_employee_view'])->name('hr.employee_view');

        Route::get('/show_holiday', [HRController::class, 'Add_holiday'])->name('hr.Add_holiday');
        Route::post('/holiday_store', [HRController::class, 'holiday_store'])->name('hr.holiday_store');
        Route::post('/holiday_edit', [HRController::class, 'holiday_edit'])->name('hr.holiday_edit');
        Route::post('/holiday_delete', [HRController::class, 'holiday_delete'])->name('hr.holiday_delete');

        Route::get('/festival', [HRController::class, 'upcoming_festival'])->name('hr.upcoming_festival');
        Route::post('/festival_store', [HRController::class, 'festival_store'])->name('hr.festival_store');
        Route::post('/festival_delete', [HRController::class, 'festival_delete'])->name('hr.festival_delete');

        Route::get('/today-attendance', [HRController::class, 'hr_today_blade'])->name('hr.today.attendance');
        Route::post('/attendance_store', [HRController::class, 'hr_store'])->name('hr.attendance.store');
        Route::post('/attendance_update', [HRController::class, 'hr_update'])->name('hr.attendance.update');
        Route::post('/attendance_delete', [HRController::class, 'hr_delete'])->name('hr.attendance.delete');
        Route::get('/employee_attendance', [HRController::class, 'employeeAttendance'])->name('hr.employee_attendance');

        Route::get('/leave_create', [HRController::class, 'hr_leave'])->name('hr.leave_request_list');
        Route::post('/leave_store', [HRController::class, 'hr_leave_request_store'])->name('hr.leave_request_store');
        Route::post('/leave_edit', [HRController::class, 'hr_edit_leave_request'])->name('hr.edit_leave_request');
        Route::post('/leave_delete_user', [HRController::class, 'hr_delete_leave_request_user'])->name('hr.delete_leave_request_user');

        // Profile Edit
        Route::get('/profile-edit', [HRController::class, 'profileEdit'])->name('hr.profile.edit');
        Route::post('/profile-update', [HRController::class, 'profileUpdate'])->name('hr.profile.update');

        Route::get('/benifit_index', [HRController::class, 'benifit_index'])->name('hr.benifit_index');
        Route::get('/ot_index', [HRController::class, 'ot_index'])->name('hr.ot_index');


        Route::get('/over-time', [HRController::class, 'ot_index'])->name('hr.index.overtime');
        Route::post('/over-store', [HRController::class, 'ot_store'])->name('hr.store.overtime');
        Route::post('/over-edit', [HRController::class, 'ot_edit'])->name('hr.edit.overtime');
        Route::post('/over-delete', [HRController::class, 'ot_delete'])->name('hr.delete.overtime');

        Route::get('/benefits-time', [HRController::class, 'benifit_index'])->name('hr.index.benefits');
        Route::post('/benefits-store', [HRController::class, 'benifit_store'])->name('hr.store.benefits');
        Route::post('/benefits-edit', [HRController::class, 'benifit_edit'])->name('hr.edit.benefits');
        Route::post('/benefits-delete', [HRController::class, 'benifit_delete'])->name('hr.delete.benefits');

          // Invoice Route
          Route::get('/invoice',[HRController::class,'index'])->name('hr.invoice.index');
          Route::get('/invoice-create/{id?}', [HRController::class, 'create'])->name('hr.invoice.create');
          Route::get('/invoice-update/{id}', [HRController::class, 'update'])->name('hr.invoice.update');
          Route::get('/invoice/deleted', [HRController::class, 'deletedInvoices'])->name('hr.invoice.deleted');  
          Route::get('/invoice/preview/{id}', [HRController::class, 'preview'])->name('hr.invoices.preview');
          Route::post('invoice/restore/{id}', [HRController::class, 'restore'])->name('hr.invoice.restore');
    });
});


Route::group(['prefix' => 'team-head'], function () {
    Route::group(['middleware' => 'admin.auth'], function () {
        // Team Head Controller
        Route::get('/teamhead-dashboard', [TeamheadController::class, 'teamdashboard'])->name('teamhead.dahsboard');

        Route::get('/teamhead-company_progress', [TeamheadController::class, 'company_progress'])->name('teamhead.company_progress');
        Route::get('/teamhead-project_index', [TeamheadController::class, 'project_index'])->name('teamhead.project_index');
        Route::get('/teamhead-Client_view', [TeamheadController::class, 'Client_view'])->name('teamhead.Client_view');
        Route::get('/teamhead-Clinetincome', [TeamheadController::class, 'Clinetincome'])->name('teamhead.Clinetincome');
        Route::get('/teamhead-Client_view', [TeamheadController::class, 'Client_view'])->name('teamhead.Client_view');
        Route::get('/invoice',[TeamheadController::class,'index'])->name('teamhead.invoice.index');
        Route::get('/invoice-create/{id?}', [TeamheadController::class, 'create'])->name('teamhead.invoice.create');
        Route::get('/invoice/preview/{id}', [TeamheadController::class, 'preview'])->name('teamhead.invoices.preview');
        Route::get('/invoice-update/{id}', [TeamheadController::class, 'update'])->name('teamhead.invoice.update');
        Route::get('/invoice/deleted', [TeamheadController::class, 'deletedInvoices'])->name('teamhead.invoice.deleted');
        Route::post('invoice/restore/{id}', [TeamheadController::class, 'restore'])->name('teamhead.invoice.restore');



        Route::get('/teamHead_employee', [TeamheadController::class, 'teamHead_employee_list'])->name('teamHead.teamHead_employee_list');
        Route::get('/team-head-employee-view/{id}', [TeamheadController::class, 'teamHead_employee_view'])->name('teamHead.teamHead_employee_view');

        Route::get('/teamHead_attendance_list', [TeamheadController::class, 'teamHead_attendance_list'])->name('teamHead.teamHead_attendance_list');
        Route::get('/teamHead_empolyee_attendance_list', [TeamheadController::class, 'teamHead_empolyee_attendance_list'])->name('teamHead.teamHead_empolyee_attendance_list');
        Route::get('/teamHead_attendance_sheet', [TeamheadController::class, 'teamHead_attendance_sheet'])->name('teamHead.teamHead_attendance_sheet');


        Route::get('/empolyee_leave_list', [TeamheadController::class, 'teamHead_empolyee_leave_list'])->name('teamHead.teamHead_empolyee_leave_list');
        Route::post('/empolyee_leave_approved', [TeamheadController::class, 'teamHead_user_request_leave_approved'])->name('teamHead.teamHead_user_request_leave_approved');
        Route::post('/empolyee_leave_delete_teamhead', [TeamheadController::class, 'teamHead_user_request_leave_delete'])->name('teamHead.teamHead_user_request_leave_delete');



        Route::get('/teamHead_leave_create', [TeamheadController::class, 'teamHead_leave'])->name('teamHead.teamHead_leave');
        Route::post('/teamHead_leave_store', [TeamheadController::class, 'teamHead_leave_request_store'])->name('teamHead.teamHead_leave_request_store');
        Route::post('/teamHead_leave_edit', [TeamheadController::class, 'teamHead_edit_leave_request'])->name('teamHead.teamHead_edit_leave_request');
        Route::post('/teamHead_leave_delete_user', [TeamheadController::class, 'teamHead_delete_leave_request'])->name('teamHead.teamHead_delete_leave_request');

        // Profile Edit
        Route::get('/profile-edit', [TeamheadController::class, 'teamhead_profileEdit'])->name('teamhead.profile.edit');
        Route::post('/profile-update', [TeamheadController::class, 'teamhead_profileUpdate'])->name('teamhead.profile.update');
    });
});


Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'admin.auth'], function () {

        Route::get('/user-dashboard', [UserController::class, 'Userdashboard'])->name('user.dahsboard');


        Route::get('/user-company_progress', [UserController::class, 'company_progress'])->name('user.company_progress');
        Route::get('/user-project', [UserController::class, 'project_index'])->name('user.project_index');
        Route::get('/user-client_view', [UserController::class, 'Client_view'])->name('user.Client_view');
        Route::get('/user-Clinetincome', [UserController::class, 'Clinetincome'])->name('user.Clinetincome');
        Route::get('/invoice',[UserController::class,'index'])->name('user.invoice.index');
        Route::get('/invoice-create/{id?}', [UserController::class, 'create'])->name('user.invoice.create');
        Route::get('/invoice/preview/{id}', [UserController::class, 'preview'])->name('user.invoices.preview');
        Route::get('/invoice-update/{id}', [UserController::class, 'update'])->name('user.invoice.update');
        Route::get('/invoice/deleted', [UserController::class, 'deletedInvoices'])->name('user.invoice.deleted');
        Route::post('invoice/restore/{id}', [UserController::class, 'restore'])->name('user.invoice.restore');

        Route::get('/user-attendance-list', [UserController::class, 'user_attendance_list'])->name('user.user_attendance_list');
        Route::get('/user-attendance-sheet', [UserController::class, 'user_attendance_sheet'])->name('user.user_attendance_sheet');

        Route::get('/user_leave_create', [UserController::class, 'user_leave'])->name('user.leave_request_create');
        Route::post('/user_leave_store', [UserController::class, 'user_leave_request_store'])->name('user.leave_request_store');
        Route::post('/user_leave_edit', [UserController::class, 'user_edit_leave_request'])->name('user.edit_leave_request');
        Route::post('/user_leave_delete_user', [UserController::class, 'user_delete_leave_request'])->name('user.delete_leave_request');

        // Profile Edit
        Route::get('/profile-edit', [UserController::class, 'profileEdit'])->name('User.profile.edit');
        Route::post('/profile-update', [UserController::class, 'profileUpdate'])->name('User.profile.update');
    });
});
