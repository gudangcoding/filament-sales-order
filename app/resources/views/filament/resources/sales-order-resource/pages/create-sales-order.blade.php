<!-- resources/views/filament/resources/sales-order-resource/pages/create-sales-order.blade.php -->
@extends('filament::page')

@section('content')
    <div class="form-section">
        {{ $this->form }}
    </div>

    <div class="relation-manager-section">
        @livewire($relationManager, ['ownerRecord' => $record])
    </div>

    <div class="additional-form-section">
        <!-- Tambahkan form tambahan di sini -->
        {{ $this->form->getComponent('additional_field') }}
    </div>
@endsection
