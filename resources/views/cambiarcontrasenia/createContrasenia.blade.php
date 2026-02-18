@extends('layouts.app')

@section('title', 'Seguridad de la Cuenta')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

            <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 bg-[#227199] rounded-lg flex items-center justify-center text-white shadow-sm">
                    <i class="bi bi-shield-lock-fill text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-[#004a77]">Seguridad de la Cuenta</h2>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl text-sm flex items-center gap-2 animate-fade-in">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('cambiarcontrasenia.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="max-w-md mx-auto">
                    <label class="block text-sm font-bold text-[#004a77] mb-2">Contraseña Actual <span class="text-danger">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#227199]">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <input type="password" name="current_password" required
                               class="block w-full pl-11 pr-4 py-2.5 bg-white border @error('current_password') border-red-400 @else border-slate-300 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#227199] transition-all"
                               placeholder="Ingrese su contraseña actual">
                    </div>
                    @error('current_password')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-slate-100 my-8"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-[#004a77] mb-2">Nueva Contraseña <span class="text-danger">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#227199]">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                            <input type="password" name="new_password" required minlength="8"
                                   class="block w-full pl-11 pr-4 py-2.5 bg-white border @error('new_password') border-red-400 @else border-slate-300 @enderror rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#227199] transition-all"
                                   placeholder="Mínimo 8 caracteres">
                        </div>
                        @error('new_password')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#004a77] mb-2">Confirmar Nueva Contraseña <span class="text-danger">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#227199]">
                                <i class="bi bi-shield-check-fill"></i>
                            </div>
                            <input type="password" name="new_password_confirmation" required minlength="8"
                                   class="block w-full pl-11 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#227199] transition-all"
                                   placeholder="Repita la contraseña">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-4 pt-6">
                    <button type="submit"
                            class="bg-[#56b3f5] hover:bg-[#45a2e4] text-white font-bold py-3 px-10 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95 text-sm min-w-[200px]">
                        <i class="bi bi-arrow-repeat me-2"></i>Actualizar Contraseña
                    </button>
                    <a href="{{ url()->previous() }}"
                       class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-600 font-bold py-3 px-10 rounded-xl transition-all text-sm min-w-[150px] text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection