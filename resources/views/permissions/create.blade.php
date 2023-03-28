<x-app-layout>
    <x-slot name="header">
    <div class="flex">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Permission') }}
        </h2>
    </x-slot>

    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="w-full px-6 py-4 bg-white sm:rounded-lg shadow-md ">
            @if (isset($errors) && count($errors))
            <div class="p-3 rounded bg-red-500 text-red-100 my-2 mb-4 text-sm">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }} </li>
                @endforeach
            </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('permission-plus.permissions.store', request()->query()) }}">
                @csrf

                <div>
                    <x-permission-plus::label>Name</x-permission-plus::label>

                    <input class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="name" value="{{old('name')}}">
                    @error('name')
                    <span class="text-red-600 text-sm">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4">
                    <x-permission-plus::label>Methods</x-permission-plus::label>

                    <div class="flex justify-start space-x-4">
                        @foreach ($methods as $method)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-input appearance-none  h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" name="methods[]" value="{{ $method }}" {{ old('methods') ===1 ? 'checked':'' }} >
                            <label class="form-check-label inline-block text-gray-800" for="inlineRadio10">{{ $method }}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('methods')
                    <span class="text-red-600 text-sm">
                        {{ $message }}
                    </span>
                    @enderror
                </div>


                <div class="mt-4">

                    <x-permission-plus::label>URI</x-permission-plus::label>

                    <input class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="uri"  value="{{old('uri')}}">
                    @error('uri')
                    <span class="text-red-600 text-sm">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4">

                    <x-permission-plus::label>Route Name</x-permission-plus::label>

                    <input class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="route_name" value="{{old('route_name')}}">
                    @error('route_name')
                    <span class="text-red-600 text-sm">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4">

                    <x-permission-plus::label>Action Name</x-permission-plus::label>

                    <textarea name="action_name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 placeholder:text-right focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4" >{{old('action_name')}}</textarea>
                    @error('action_name')
                    <span class="text-red-600 text-sm">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4">

                    <x-permission-plus::label>Allow All?</x-permission-plus::label>

                    <div class="flex justify-start space-x-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="allow_all" value="1" {{ old('allow_all') ===1 ? 'checked':'' }} onclick="onAllowAllClick(this.value);">
                            <label class="form-check-label inline-block text-gray-800" for="inlineRadio10">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="allow_all" value="0" {{ old('allow_all') ===0 ? 'checked':'' }} onclick="onAllowAllClick(this.value);">
                            <label class="form-check-label inline-block text-gray-800" for="inlineRadio20">No</label>
                        </div>

                    </div>
                    @error('allow_all')
                    <span class="text-red-600 text-sm">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="mt-4" id="allow-guest-section">

                    <x-permission-plus::label>Allow Guest?</x-permission-plus::label>

                    <div class="flex justify-start space-x-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="allow_guest" value="1" {{ old('allow_guest') ===1 ? 'checked':'' }} >
                            <label class="form-check-label inline-block text-gray-800" for="inlineRadio10">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="allow_guest" value="0" {{ old('allow_guest') ===0 ? 'checked':'' }} >
                            <label class="form-check-label inline-block text-gray-800" for="inlineRadio20">No</label>
                        </div>

                    </div>
                    @error('allow_guest')
                    <span class="text-red-600 text-sm">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                @if($roles)
                <div class="mt-4" id="roles-section">

                    <x-permission-plus::label>Allowed Roles</x-permission-plus::label>

                    @foreach ($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200  align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer mt-1" type="checkbox" value="{{ $role->id }}" name="roles[]" {{ old('roles') ? 'checked':'' }}>
                        <label class="form-check-label inline-block text-gray-800" for="allow_all">
                            {{ Str::title($role->name) }}
                        </label>
                    </div>
                    @endforeach



                </div>
                @endif


                <div class="flex items-center justify-start mt-6">
                    <x-permission-plus::primary-button >Create</x-permission-plus::primary-button >
                    <x-permission-plus::primary-link href="{{ route('permission-plus.permissions.index', request()->query())}}" class="ml-2">Back</x-permission-plus::primary-link >
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script>
let currAllowAll = document.querySelector('input[name="allow_all"]:checked');
if(currAllowAll){
    onAllowAllClick(currAllowAll.value)
}


function onAllowAllClick(value) {

    let rolesSection = document.getElementById("roles-section");
    let allowGuestSection = document.getElementById("allow-guest-section");

    if(value==1){
        rolesSection.classList.add("hidden");
        allowGuestSection.classList.add("hidden");
    }else{
        rolesSection.classList.remove("hidden");
        allowGuestSection.classList.remove("hidden");
    }

}
</script>
