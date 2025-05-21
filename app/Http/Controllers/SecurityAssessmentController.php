<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Assessment;
use Illuminate\Http\Request;

class SecurityAssessmentController extends Controller
{
    private $securityQuestions = [
        // Security Policy section
        "Organizația are o politică oficială de securitate a informației aprobată de conducere",
        "Politica de securitate este comunicată tuturor angajaților",
        "Politica este revizuită anual sau ori de câte ori este necesar.",
        "Politica include obiective clare privind protejarea informațiilor.",
        "Există un plan pentru implementarea politicii de securitate.",

        // Organization of Information Security section
        "Există un responsabil desemnat pentru securitatea informației.",
        "Responsabilitățile privind securitatea sunt clar definite în cadrul organizației.",
        "Partenerii externi care accesează informații sunt evaluați din punct de vedere al riscurilor.",
        "Colaborarea interdepartamentală este asigurată pentru respectarea politicilor de securitate.",
        "Se menține un registru al furnizorilor cu acces la informații sensibile.",

        // Asset Management section
        "Toate activele informaționale sunt inventariate și clasificate.",
        "Fiecare activ are un proprietar desemnat.",
        "Se aplică reguli clare privind utilizarea acceptabilă a activelor.",
        "Activele sunt etichetate în funcție de nivelul de sensibilitate.",
        "Se aplică proceduri pentru eliminarea în siguranță a echipamentelor IT.",

        // Human Resources Security section
        "Toți angajații semnează acorduri de confidențialitate.",
        "Angajații beneficiază de instruiri periodice privind securitatea cibernetică.",
        "Există proceduri pentru gestionarea accesului în cazul plecării unui angajat.",
        "Politica interzice partajarea parolelor sau conturilor de utilizator.",

        // Physical and Environmental Security section
        "Accesul fizic în birouri este controlat prin sisteme electronice.",
        "Zonele cu echipamente critice sunt protejate prin supraveghere video.",
        "Există detectoare de incendiu și planuri de evacuare în caz de urgență.",

        // Communication and Operations Management section
        "Toate activitățile IT sunt înregistrate în jurnale de sistem.",
        "Software-ul este actualizat periodic pentru corectarea vulnerabilităților.",
        "Existența unor proceduri de backup testate și documentate.",
        "Transferul de date se face doar prin canale criptate.",
        "Se monitorizează permanent activitatea rețelei pentru identificarea incidentelor."
    ];

    public function index()
    {
        return view('security.index');
    }

    public function startAssessment(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255'
        ]);

        $company = Company::firstOrCreate(['name' => $request->company_name]);

        return view('security.assessment', [
            'company' => $company,
            'questions' => $this->securityQuestions
        ]);
    }

    public function submitAssessment(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'answers' => 'required|array'
        ]);

        $company = Company::findOrFail($request->company_id);
        $answers = $request->answers;
        
        $totalQuestions = count($this->securityQuestions);
        $totalYes = count(array_filter($answers, fn($answer) => $answer === 'yes'));
        $totalNo = $totalQuestions - $totalYes;
        $percentage = ($totalYes / $totalQuestions) * 100;
        $passed = $percentage >= 70;

        $assessment = Assessment::create([
            'company_id' => $company->id,
            'answers' => $answers,
            'total_yes' => $totalYes,
            'total_no' => $totalNo,
            'total_questions' => $totalQuestions,
            'percentage' => $percentage,
            'passed' => $passed
        ]);

        return view('security.results', [
            'company' => $company,
            'assessment' => $assessment
        ]);
    }

    public function savedCompanies()
    {
        $companies = Company::with('latestAssessment')->get();
        return view('security.saved-companies', compact('companies'));
    }

    public function deleteCompany(Company $company)
    {
        $company->delete();
        return redirect()->route('security.saved-companies')->with('success', 'Company deleted successfully');
    }

    public function editAssessment(Company $company)
    {
        $latestAssessment = $company->latestAssessment;
        
        return view('security.edit-assessment', [
            'company' => $company,
            'assessment' => $latestAssessment,
            'questions' => $this->securityQuestions
        ]);
    }

    public function updateAssessment(Request $request, Company $company)
    {
        $request->validate([
            'answers' => 'required|array'
        ]);

        $answers = $request->answers;
        
        // Calculate results
        $totalQuestions = count($this->securityQuestions);
        $totalYes = count(array_filter($answers, fn($answer) => $answer === 'yes'));
        $totalNo = $totalQuestions - $totalYes;
        $percentage = ($totalYes / $totalQuestions) * 100;
        $passed = $percentage >= 70;

        // Update or create new assessment
        $assessment = $company->latestAssessment;
        if ($assessment) {
            $assessment->update([
                'answers' => $answers,
                'total_yes' => $totalYes,
                'total_no' => $totalNo,
                'total_questions' => $totalQuestions,
                'percentage' => $percentage,
                'passed' => $passed
            ]);
        } else {
            $assessment = Assessment::create([
                'company_id' => $company->id,
                'answers' => $answers,
                'total_yes' => $totalYes,
                'total_no' => $totalNo,
                'total_questions' => $totalQuestions,
                'percentage' => $percentage,
                'passed' => $passed
            ]);
        }

        return view('security.results', [
            'company' => $company,
            'assessment' => $assessment
        ]);
    }
}