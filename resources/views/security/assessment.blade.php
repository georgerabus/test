@extends('app')
@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                Security Assessment for {{ $company->name }}
            </h2>
            <p class="text-gray-600 mt-2">
                Answer the following questions to evaluate your ISO 27001 compliance
            </p>
        </div>
        
        <form action="{{ route('security.submit-assessment') }}" method="POST">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">
            
            <div class="space-y-8">
                @php
                    $categories = [
                        'Security Policy' => [0, 1, 2, 3, 4],
                        'Organization of Information Security' => [5, 6, 7, 8, 9],
                        'Asset Management' => [10, 11, 12, 13, 14],
                        'Human Resources Security' => [15, 16, 17, 18],
                        'Physical and Environmental Security' => [19, 20, 21],
                        'Communication and Operations Management' => [22, 23, 24, 25, 26]
                    ];
                    $questionIndex = 0;
                @endphp

                @foreach($categories as $categoryName => $questionIndices)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-800 rounded-full text-sm font-medium mr-3">
                                    {{ $loop->iteration }}
                                </span>
                                {{ $categoryName }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ count($questionIndices) }} questions in this category
                            </p>
                        </div>

                        <div class="bg-white p-6">
                            <div class="space-y-6">
                                @foreach($questionIndices as $index)
                                    @if(isset($questions[$index]))
                                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                            <h4 class="text-lg font-medium text-gray-900 mb-4">
                                                <span class="text-blue-600 font-semibold">{{ $index + 1 }}.</span>
                                                {{ $questions[$index] }}
                                            </h4>
                                            <div class="flex space-x-6">
                                                <label class="flex items-center cursor-pointer hover:bg-green-50 p-2 rounded-md transition-colors">
                                                    <input
                                                        type="radio"
                                                        name="answers[{{ $index }}]"
                                                        value="yes"
                                                        required
                                                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 question-radio"
                                                        data-answer="yes"
                                                        data-category="{{ $categoryName }}"
                                                    >
                                                    <span class="ml-2 text-green-700 font-medium">Da</span>
                                                    <svg class="w-4 h-4 ml-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </label>
                                                <label class="flex items-center cursor-pointer hover:bg-red-50 p-2 rounded-md transition-colors">
                                                    <input
                                                        type="radio"
                                                        name="answers[{{ $index }}]"
                                                        value="no"
                                                        required
                                                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 question-radio"
                                                        data-answer="no"
                                                        data-category="{{ $categoryName }}"
                                                    >
                                                    <span class="ml-2 text-red-700 font-medium">Nu</span>
                                                    <svg class="w-4 h-4 ml-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                        @php $questionIndex++; @endphp
                                    @endif
                                @endforeach
                            </div>

                            <div class="mt-6 bg-gray-100 rounded-full h-2">
                                <div class="category-progress bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                     data-category="{{ $categoryName }}" 
                                     style="width: 0%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm text-gray-600">Progress for this category</span>
                                <span class="category-progress-text text-sm font-medium text-gray-700" 
                                      data-category="{{ $categoryName }}">0/{{ count($questionIndices) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8 bg-blue-50 p-6 rounded-lg border border-blue-200">
                <h4 class="text-lg font-semibold text-gray-900 mb-3">Overall Assessment Progress</h4>
                <div class="bg-white rounded-full h-3">
                    <div id="overall-progress" class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-gray-600">Total questions answered</span>
                    <span id="overall-progress-text" class="text-sm font-medium text-gray-700">0/{{ count($questions) }}</span>
                </div>
            </div>
            
            <div class="mt-8 flex justify-between">
                <div class="flex space-x-4">
                    <a
                        href="{{ route('security.index') }}"
                        class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200"
                    >
                        Cancel
                    </a>
                    <button
                        type="button"
                        id="toggleSelect"
                        class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200 text-sm font-medium"
                    >
                        Select All "Yes"
                    </button>
                    <button
                        type="button"
                        id="unselectAll"
                        class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-200 text-sm font-medium"
                    >
                        Unselect All
                    </button>
                </div>
                <button
                    type="submit"
                    id="submitBtn"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200 font-medium disabled:bg-gray-400 disabled:cursor-not-allowed"
                    disabled
                >
                    Submit Assessment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleSelect');
    const unselectBtn = document.getElementById('unselectAll');
    const submitBtn = document.getElementById('submitBtn');
    const radioButtons = document.querySelectorAll('.question-radio');
    const totalQuestions = {{ count($questions) }};
    
    let isSelectingYes = true;

    function updateProgress() {
        const categories = {
            'Security Policy': 5,
            'Organization of Information Security': 5,
            'Asset Management': 5,
            'Human Resources Security': 4,
            'Physical and Environmental Security': 3,
            'Communication and Operations Management': 5
        };

        let totalAnswered = 0;

        Object.keys(categories).forEach(category => {
            const categoryRadios = document.querySelectorAll(`input[data-category="${category}"]:checked`);
            const answered = categoryRadios.length;
            const total = categories[category];
            const percentage = (answered / total) * 100;

            const progressBar = document.querySelector(`.category-progress[data-category="${category}"]`);
            const progressText = document.querySelector(`.category-progress-text[data-category="${category}"]`);
            
            if (progressBar && progressText) {
                progressBar.style.width = percentage + '%';
                progressText.textContent = `${answered}/${total}`;
            }

            totalAnswered += answered;
        });

        const overallPercentage = (totalAnswered / totalQuestions) * 100;
        const overallProgressBar = document.getElementById('overall-progress');
        const overallProgressText = document.getElementById('overall-progress-text');
        
        if (overallProgressBar && overallProgressText) {
            overallProgressBar.style.width = overallPercentage + '%';
            overallProgressText.textContent = `${totalAnswered}/${totalQuestions}`;
        }

        submitBtn.disabled = totalAnswered !== totalQuestions;
    }

    radioButtons.forEach(radio => {
        radio.addEventListener('change', updateProgress);
    });

    toggleBtn.addEventListener('click', function() {
        if (isSelectingYes) {
            radioButtons.forEach(radio => {
                if (radio.getAttribute('data-answer') === 'yes') {
                    radio.checked = true;
                }
            });
            toggleBtn.textContent = 'Select All "No"';
            toggleBtn.className = 'bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 text-sm font-medium';
            isSelectingYes = false;
        } else {
            radioButtons.forEach(radio => {
                if (radio.getAttribute('data-answer') === 'no') {
                    radio.checked = true;
                }
            });
            toggleBtn.textContent = 'Select All "Yes"';
            toggleBtn.className = 'bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200 text-sm font-medium';
            isSelectingYes = true;
        }
        updateProgress();
    });

    unselectBtn.addEventListener('click', function() {
        radioButtons.forEach(radio => {
            radio.checked = false;
        });
        toggleBtn.textContent = 'Select All "Yes"';
        toggleBtn.className = 'bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200 text-sm font-medium';
        isSelectingYes = true;
        updateProgress();
    });

    updateProgress();
});
</script>
@endsection