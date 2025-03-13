@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Edit Flash Timer</div>
                    <div class="text-sm font-medium text-gray-400">Update existing flash timer details</div>
                </div>
                <div class="dropdown">
                    <button type="button"
                        class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                        <i class="ri-more-2-fill"></i>
                    </button>
                    <div
                        class="dropdown-menu hidden shadow-md shadow-black/5 z-30 w-full max-w-[140px] bg-white rounded-md border border-gray-100">
                        <ul>
                            <li>
                                <a href="{{ route('flash.sale.timer.show') }}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-file-list-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">All Flash
                                        Timers</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <form action="{{ route('flash.sale.timer.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="id" value="{{ $timer->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Flash Timer Code Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                            <input type="datetime-local" name="start_time" value="{{ $timer->start_time }}"
                                placeholder="Enter flash timer code"
                                class="w-full px-4 py-2 border @error('start_time') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('start_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Flash Timer Code</label>
                            <input type="datetime-local" name="end_time" value="{{ $timer->end_time }}"
                                placeholder="Enter flash timer code"
                                class="w-full px-4 py-2 border @error('end_time') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('end_time')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>




                        <!-- Coupon status -->
                        <!-- status Toggle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Coupon status</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="status" value="inactive">
                                <input type="checkbox" name="status" value="active" class="sr-only peer"
                                    {{ $timer->status === 'active' ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900">
                                    {{ $timer->status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-start pt-4">
                        <button type="submit"
                            class="px-6 py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Update Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
