<?php

use App\Http\Controllers\SecurityAssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SecurityAssessmentController::class, 'index'])->name('security.index');

Route::match(['get', 'post'], '/start-assessment', [SecurityAssessmentController::class, 'startAssessment'])->name('security.start-assessment');

Route::post('/submit-assessment', [SecurityAssessmentController::class, 'submitAssessment'])->name('security.submit-assessment');

Route::get('/saved-companies', [SecurityAssessmentController::class, 'savedCompanies'])->name('security.saved-companies');

Route::delete('/companies/{company}', [SecurityAssessmentController::class, 'deleteCompany'])->name('security.delete-company');

Route::get('/companies/{company}/edit', [SecurityAssessmentController::class, 'editAssessment'])->name('security.edit-assessment');

Route::put('/companies/{company}/update', [SecurityAssessmentController::class, 'updateAssessment'])->name('security.update-assessment');