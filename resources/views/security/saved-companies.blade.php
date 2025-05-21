@extends('app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Saved Companies</h2>
            <a 
                href="{{ route('security.index') }}"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
            >
                New Assessment
            </a>
        </div>

        @if($companies->isEmpty())
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">📊</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No assessments yet</h3>
                <p class="text-gray-600 mb-6">Start your first security assessment to see results here.</p>
                <a 
                    href="{{ route('security.index') }}"
                    class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Start Assessment
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Company Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Compliance Score
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Updated
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($companies as $company)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $company->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($company->latestAssessment)
                                    <div class="text-sm text-gray-900">
                                        {{ number_format($company->latestAssessment->percentage, 1) }}%
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $company->latestAssessment->total_yes }}/{{ $company->latestAssessment->total_questions }} controls
                                    </div>
                                @else
                                    <span class="text-gray-400">No assessment</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($company->latestAssessment)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $company->latestAssessment->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $company->latestAssessment->passed ? 'Passed' : 'Failed' }}
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Not assessed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($company->latestAssessment)
                                    {{ $company->latestAssessment->updated_at->format('M d, Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                @if($company->latestAssessment)
                                    <a 
                                        href="{{ route('security.edit-assessment', $company) }}"
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        Modify
                                    </a>
                                @else
                                    <a 
                                        href="{{ route('security.start-assessment') }}?company_name={{ urlencode($company->name) }}"
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        Assess
                                    </a>
                                @endif
                                <form 
                                    action="{{ route('security.delete-company', $company) }}" 
                                    method="POST" 
                                    class="inline"
                                    {{-- onsubmit="return confirm('Are you sure you want to delete this company and all its assessments?')" --}}
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="mt-4 bg-green-50 border border-green-200 rounded-md p-4">
        <div class="text-green-800">{{ session('success') }}</div>
    </div>
@endif
@endsection