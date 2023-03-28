<x-app-layout>
    <x-slot name="header">
        <div class="flex content-center items-center">
            <h2 class="flex-none text-xl font-semibold leading-tight text-gray-800 ">
                {{ __('Permissions') }}
            </h2>

            <div class="flex-1 ">
                <div class="flex justify-end space-x-4 items-center">

                    <form method="POST" action="{{ route('permission-plus.permissions.generate') }}" class="inline inline-flex gap-x-4 content-center items-center">
                        @csrf

                        @if($permissions->count() > 0)
                        <div class="form-check">
                            <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200  align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer mt-1" type="checkbox" value="1" name="overwrite" >
                            <label class="form-check-label inline-block text-gray-800" for="allow_all">
                                Overwrite
                            </label>
                        </div>
                        @endif
                        <x-permission-plus::primary-button >Generate</x-permission-plus::primary-button >
                    </form>
                    <div>
                    <x-permission-plus::primary-link href="{{ route('permission-plus.permissions.create', request()->query())}}">Create</x-permission-plus::primary-link >
                </div>

            </div>
        </div>
    </x-slot>
    <!-- Index Post -->
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if (session()->has('message'))
        <div class="p-3 rounded bg-green-500 text-green-100 my-2 mb-4 text-sm">
            {{ session('message') }}
        </div>
        @endif

        <form method="GET" action="{{ route('permission-plus.permissions.index') }}">
            <div class="flex flex-col sm:flex-row gap-x-4 mb-4 content-center items-center">
                <input placeholder="Enter search terms" class="flex-1 block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400  focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="search" value="{{ request()->search }}">
                <div class="flex w-full sm:w-auto mt-4 sm:mt-0 sm:justify-center justify-start content-center items-center">
                    <x-permission-plus::primary-button>Search</x-permission-plus::primary-button >
                    <x-permission-plus::primary-link href="{{ route('permission-plus.permissions.index')}}" class="ml-2">Reset</x-permission-plus::primary-link >
                </div>
            </div>
        </form>

        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Action Name
                                </th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-center text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Permission
                                </th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Created At
                                </th>
                                 <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Updated At
                                </th>
                                <th class="px-6 py-3 text-sm text-center text-gray-500 border-b border-gray-200 bg-gray-50">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">

                            @forelse ($permissions as $permission)

                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center leading-5 text-sm text-gray-900">
                                        {{ $permission->id }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="leading-5 text-sm text-gray-900">
                                        {{ $permission->name }}
                                    </div>
                                    <div class="text-xs leading-5 text-gray-400">
                                        {{ $permission->method_text ? "[".$permission->method_text."]" : "" }} {{ $permission->uri }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="leading-5 text-sm text-gray-900">{{ $permission->permission_text }} </div>
                                </td>

                                <td class="px-6 py-4 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class=" leading-5 text-sm text-gray-900"> {{ $permission->created_at }}</div>
                                </td>

                                <td class="px-6 py-4 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class=" leading-5 text-sm text-gray-900"> {{ $permission->updated_at }}</div>
                                </td>

                                <td class="text-sm font-medium leading-5 text-center whitespace-no-wrap border-b border-gray-200 ">
                                <div class="flex justify-center gap-2 content-center items-center">

                                    <a href="{{ route('permission-plus.permissions.edit', [ 'permission'=>$permission->id] + request()->query() ) }}" class="text-indigo-600 hover:text-indigo-900 inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('permission-plus.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('Are You Sure ? ') }}');">

                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                        <button type="submit" class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600 hover:text-red-800 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                </td>
                                <td class="text-sm font-medium leading-5 whitespace-no-wrap border-b border-gray-200 ">

                                </td>
                            </tr>
                           @empty
                           <tr >
                                <td colspan="100%" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">Click <strong>Generate</strong> button to generate permissions.</td>
                           </tr>
                           @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
         {{ $permissions->links() }}
        </div>

    </div>
</x-app-layout>
