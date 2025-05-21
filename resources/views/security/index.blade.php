@extends('app')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">
                ISO 27001 Security Assessment Platform
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Evaluate your organization's security posture against ISO 27001 standards
            </p>
        </div>

        <div class="max-w-md mx-auto">
            <form action="{{ route('security.start-assessment') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Company Name
                    </label>
                    <input 
                        type="text" 
                        id="company_name" 
                        name="company_name" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your company name"
                    >
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-4">
                    <button 
                        type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium transition duration-200"
                    >
                        Start Security Assessment
                    </button>

                    <a 
                        href="{{ route('security.saved-companies') }}"
                        class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 font-medium transition duration-200 text-center block"
                    >
                        View Saved Companies
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
