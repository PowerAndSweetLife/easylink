<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContainerController as AdminContainerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FactureController;
use App\Http\Controllers\Admin\LocalizationController;
use App\Http\Controllers\Admin\MadaAgentController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Agent\AuthController as AgentAuthController;
use App\Http\Controllers\Agent\BookingController;
use App\Http\Controllers\Agent\ContainerController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\ExpeditionController as AgentExpeditionController;
use App\Http\Controllers\Agent\ManifestController;
use App\Http\Controllers\Agent\ProfilController as AgentProfilController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\ColisController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ExpeditionController;
use App\Http\Controllers\Client\FactureController as ClientFactureController;
use App\Http\Controllers\Client\Messagecontroller;
use App\Http\Controllers\Client\ProfilController as ClientProfilController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\MadaAgent\AuthController as MadaAgentAuthController;
use App\Http\Controllers\MadaAgent\ContainerController as MadaAgentContainerController;
use App\Http\Controllers\MadaAgent\DashboardController as MadaAgentDashboardController;
use App\Http\Controllers\MadaAgent\FacturationController;
use App\Http\Controllers\MadaAgent\LivraisonController;
use App\Http\Controllers\MadaAgent\ProfilController as MadaAgentProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ClientDashboardController::class, 'index'])->name('client.index')->middleware('user.session');


/**
 * ========================================Authentification=======================================
 */
Route::name('client.')->controller(AuthController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'doLogin')->name('login');
    Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
    Route::get('/confirm-email', 'confirmEmail')->name('confirm-email')->middleware('client.confirmation');
    Route::post('/confirm-email', 'doConfirmEmail')->middleware('client.confirmation');
    Route::get('/change-email', 'editEmail')->name('change-email')->middleware('client.confirmation');
    Route::put('/update-email', 'updateEmail')->name('update-email')->middleware('client.confirmation');
    Route::get('/regenerate-code', 'regenerateCode')->name('regenerate-code')->middleware('client.confirmation');
    Route::delete('/logout', 'logout')->name('logout')->middleware('user.session');
});
Route::get('/register/{type}', [RegisterController::class, 'index'])->name('client.register');
Route::post('/register/particulier', [RegisterController::class, 'particulier'])->name('client.register.particulier');
Route::post('/register/entreprise', [RegisterController::class, 'entreprise'])->name('client.register.entreprise');

Route::prefix('agent')->name('agent.')->controller(AgentAuthController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'doLogin');
    Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
    Route::delete('/logout', 'logout')->name('logout')->middleware('user.session');
});

Route::prefix('agent/mada')->name('mada-agent.')->controller(MadaAgentAuthController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'doLogin');
    Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
    Route::delete('/logout', 'logout')->name('logout')->middleware('user.session');
});

Route::prefix('admin')->name('admin.')->controller(AdminAuthController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'doLogin');
    Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
    Route::delete('/logout', 'logout')->name('logout')->middleware('user.session');
});

/**
 * ========================================Dashboard client=======================================
 */
Route::get('/client', [ClientDashboardController::class, 'index'])->name('client.index')->middleware('user.session');
Route::prefix('client')->name('client.')->middleware('user.session')->group(function() {
    Route::put('/lang/{code}', [ClientDashboardController::class, 'changeLanguage'])->name('lang');
    Route::resource("colis", ColisController::class);
    Route::resource("expedition", ExpeditionController::class);
    Route::get('/profil', [ClientProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/change-password', [ClientProfilController::class, 'password'])->name('profil.password');
    Route::put('/profil/{client}/company', [ClientProfilController::class, 'updateInfoCompany'])->name('profil.updateInfo.company');
    Route::put('/profil/{client}/individual', [ClientProfilController::class, 'updateInfoIndividual'])->name('profil.updateInfo.individual');
    Route::put('/profil/change-password/{client}', [ClientProfilController::class, 'updatePassword'])->name('profil.updatePassword');

    Route::get('/facture', [ClientFactureController::class, 'index'])->name('facture.index');
    Route::get('/facture/{id}/history', [ClientFactureController::class, 'history'])->name('facture.history');
    Route::get('/facture/{id}/print', [ClientFactureController::class, 'print'])->name('facture.print');
    Route::get('/carte-fidelite', [ClientProfilController::class, 'fidelityCard'])->name('fidelityCard');
    //Route::resource('subclient', SubclientController::class);
    Route::resource('message', Messagecontroller::class);

    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    // Route::post('/search', [SearchController::class, 'run']);
    Route::get('/adresse-livraison', [ClientDashboardController::class, 'easylink'])->name('easylink');

});


/**
 * ========================================Dashboard admin========================================
 */
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.index')->middleware('user.session');
Route::prefix('admin')->name('admin.')->middleware('user.session')->group(function() {
    Route::put('/lang/{code}', [DashboardController::class, 'changeLanguage'])->name('lang');
    Route::resource("setting", SettingController::class);
    Route::get('/cbm/edit', [SettingController::class, 'cbm'])->name('setting.cbm');
    Route::put('/cbm/update', [SettingController::class, 'updateCbm'])->name('setting.updateCbm');
    Route::resource("category", CategoryController::class);
    Route::resource("unit", UnitController::class);
    Route::resource("localization", LocalizationController::class);
    Route::resource("agent", AgentController::class);
    Route::resource("admin", AdminController::class);
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/change-password', [ProfilController::class, 'password'])->name('profil.password');
    Route::put('/profil/{admin}', [ProfilController::class, 'updateInfo'])->name('profil.updateInfo');
    Route::put('/profil/change-password/{admin}', [ProfilController::class, 'updatePassword'])->name('profil.updatePassword');

    Route::get('/container', [AdminContainerController::class, 'index'])->name('container.index');
    Route::get('/container/{id}/detail', [AdminContainerController::class, 'show'])->name('container.show');
    Route::get('/container/{id}/booking/list', [AdminContainerController::class, 'bookingList'])->name('container.booking.list');
    Route::get('/booking/{id}/show', [AdminContainerController::class, 'packageList'])->name('booking.show');


    Route::get('/facturation', [FactureController::class, 'index'])->name('facturation.index');
    Route::get('/facturation/{id}/edit', [FactureController::class, 'edit'])->name('facturation.edit');
    Route::get('/facturation/{id}/paiement', [FactureController::class, 'pay'])->name('facturation.paiement');
    Route::put('/facturation/{id}/paiement', [FactureController::class, 'doPay'])->name('facturation.paiement');
    Route::put('/facturation/{id}/update', [FactureController::class, 'update'])->name('facturation.update');
    Route::get('/facturation/{id}/history', [FactureController::class, 'history'])->name('facturation.history');
    Route::get('/facturation/{id}/print', [FactureController::class, 'print'])->name('facturation.print');

    Route::resource('message', AdminMessageController::class);

    Route::resource('mada-agent', MadaAgentController::class);
});


/**
 * ========================================Dashboard agent chine========================================
 */
Route::get('/agent', [AgentDashboardController::class, 'index'])->name('agent.index')->middleware('user.session');
Route::prefix('agent')->name('agent.')->middleware('user.session')->group(function() {
    Route::get('/profil', [AgentProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/change-password', [AgentProfilController::class, 'password'])->name('profil.password');
    Route::put('/profil/{agent}', [AgentProfilController::class, 'updateInfo'])->name('profil.updateInfo');
    Route::put('/profil/change-password/{agent}', [AgentProfilController::class, 'updatePassword'])->name('profil.updatePassword');
    Route::put('/lang/{code}', [AgentDashboardController::class, 'changeLanguage'])->name('lang');

    Route::get('/expedition/lists/{status}', [AgentExpeditionController::class, 'colisList'])->name('colis.list');
    Route::put('/expedition/receive', [AgentExpeditionController::class, 'receiveColis'])->name('colis.receive');
    Route::put('/expedition/receive-more', [AgentExpeditionController::class, 'receiveMoreColis'])->name('colis.receiveMore');
    Route::delete('/expedition/not-received', [AgentExpeditionController::class, 'notReceived'])->name('colis.notReceived');
    Route::get('/expedition/{id}/show', [AgentExpeditionController::class, 'showColis'])->name('colis.show');
    Route::get('/expedition/{id}/edit', [AgentExpeditionController::class, 'editColis'])->name('colis.edit');
    Route::put('/expedition/{id}/update', [AgentExpeditionController::class, 'updateColis'])->name('colis.update');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{id}/show', [BookingController::class, 'show'])->name('booking.show');
    Route::put('/booking/add-to-container', [BookingController::class, 'addToContainer'])->name('booking.container');
    Route::put('/booking/add-more-to-container', [BookingController::class, 'addMoreToContainer'])->name('booking.containerMore');

    Route::resource('container', ContainerController::class);

    Route::get("/manifest", [ManifestController::class, 'index'])->name('manifest.index');
    Route::put("/manifest", [ManifestController::class, 'send'])->name('manifest.send');
    Route::get("/manifest/{id}/show", [ManifestController::class, 'show'])->name('manifest.show');
    Route::delete("/manifest/booking/{id}/remove", [ManifestController::class, 'removeBooking'])->name('manifest.removeBooking');

    Route::delete('/colis/{id}/remove-from-booking', [BookingController::class, 'removeColis'])->name('booking.removeColis');
});

/**
 * ========================================Dashboard agent mada========================================
 */
Route::get('/agent/mada', [MadaAgentDashboardController::class, 'index'])->name('mada-agent.index')->middleware('user.session');
Route::prefix('agent/mada')->name('mada-agent.')->middleware('user.session')->group(function() {
    Route::get('/profil', [MadaAgentProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/change-password', [MadaAgentProfilController::class, 'password'])->name('profil.password');
    Route::put('/profil/{agent}', [MadaAgentProfilController::class, 'updateInfo'])->name('profil.updateInfo');
    Route::put('/profil/change-password/{agent}', [MadaAgentProfilController::class, 'updatePassword'])->name('profil.updatePassword');
    Route::put('/lang/{code}', [MadaAgentDashboardController::class, 'changeLanguage'])->name('lang');

    Route::get('/container', [MadaAgentContainerController::class, 'index'])->name('container');
    Route::get('/container/{id}/edit-date', [MadaAgentContainerController::class, 'editDate'])->name('container.editDate');
    Route::get('/container/{id}/edit-status', [MadaAgentContainerController::class, 'editStatus'])->name('container.editStatus');
    Route::get('/container/{id}/edit-price', [MadaAgentContainerController::class, 'editPrice'])->name('container.editPrice');
    Route::get('/container/{id}/detail', [MadaAgentContainerController::class, 'show'])->name('container.show');
    Route::put('/container/{id}/update-date', [MadaAgentContainerController::class, 'updateDate'])->name('container.updateDate');
    Route::put('/container/{id}/update-status', [MadaAgentContainerController::class, 'updateStatus'])->name('container.updateStatus');
    Route::put('/container/{id}/update-price', [MadaAgentContainerController::class, 'updatePrice'])->name('container.updatePrice');
    Route::get('/container/{id}/booking/list', [MadaAgentContainerController::class, 'bookingList'])->name('container.booking.list');
    Route::get('/booking/{id}/show', [MadaAgentContainerController::class, 'packageList'])->name('booking.show');

    
    Route::get('/facturation', [FacturationController::class, 'index'])->name('facturation.index');
    Route::get('/facturation/{id}/edit', [FacturationController::class, 'edit'])->name('facturation.edit');
    Route::get('/facturation/{id}/paiement', [FacturationController::class, 'pay'])->name('facturation.paiement');
    Route::put('/facturation/{id}/paiement', [FacturationController::class, 'doPay'])->name('facturation.paiement');
    Route::put('/facturation/{id}/update', [FacturationController::class, 'update'])->name('facturation.update');
    Route::get('/facturation/{id}/history', [FacturationController::class, 'history'])->name('facturation.history');
    Route::get('/facturation/{id}/print', [FacturationController::class, 'print'])->name('facturation.print');

    
    Route::get('/livraison', [LivraisonController::class, 'index'])->name('livraison.index');
    Route::put('/livraison/more', [LivraisonController::class, 'more'])->name('livraison.more');
    Route::put('/livraison/{id}', [LivraisonController::class, 'single'])->name('livraison.single');
    Route::get('/livraison/{id}/show', [LivraisonController::class, 'show'])->name('livraison.show');
});