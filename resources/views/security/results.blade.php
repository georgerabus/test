@extends('app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Assessment Results
            </h2>
            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                {{ $assessment->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $assessment->passed ? '✓ PASSED' : '✗ FAILED' }} ISO 27001 Assessment
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $assessment->company->name }}</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $assessment->total_yes }}</div>
                        <div class="text-sm text-gray-600">Achieved</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $assessment->total_no }}</div>
                        <div class="text-sm text-gray-600">Not Implemented</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $assessment->total_questions }}</div>
                        <div class="text-sm text-gray-600">Total Questions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($assessment->percentage, 1) }}%</div>
                        <div class="text-sm text-gray-600">Compliance Score</div>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Compliance Progress</span>
                        <span>{{ number_format($assessment->percentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-4 rounded-full progress-bar relative overflow-hidden"
                             style="width: {{ $assessment->percentage }}%">
                            <div class="absolute inset-0 bg-green-400 opacity-20"></div>
                        </div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>0%</span>
                        <span class="font-medium">Passing Threshold: 70%</span>
                        <span>100%</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-green-800 font-medium">Implemented Controls</span>
                            <span class="text-green-600 text-2xl font-bold">{{ $assessment->total_yes }}</span>
                        </div>
                        <div class="text-green-600 text-sm mt-1">
                            {{ number_format(($assessment->total_yes / $assessment->total_questions) * 100, 1) }}% of total
                        </div>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-red-800 font-medium">Missing Controls</span>
                            <span class="text-red-600 text-2xl font-bold">{{ $assessment->total_no }}</span>
                        </div>
                        <div class="text-red-600 text-sm mt-1">
                            {{ number_format(($assessment->total_no / $assessment->total_questions) * 100, 1) }}% of total
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a 
                    href="{{ route('security.edit-assessment', $assessment->company) }}"
                    class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-center"
                >
                    Reattempt Checklist
                </a>
                <a 
                    href="{{ route('security.index') }}"
                    class="bg-gray-600 text-white py-3 px-6 rounded-lg hover:bg-gray-700 transition duration-200 font-medium text-center"
                >
                    New Assessment
                </a>
                <a 
                    href="{{ route('security.saved-companies') }}"
                    class="bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition duration-200 font-medium text-center"
                >
                    View All Companies
                </a>
            </div>
        </div>
    </div>
</div>
@endsection