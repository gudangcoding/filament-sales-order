@extends('filament::page')

@section('content')
    <div class="grid grid-cols-1 gap-4">
        <div class="form-section">
            {{ $this->form }}
        </div>

        <div class="relation-manager-section">
            @livewire($relationManager, ['ownerRecord' => $record])
        </div>

        <div class="additional-form-section">
            <x-filament::card>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        {{ $this->form->getComponent('total') }}
                    </div>
                    <div>
                        {{ $this->form->getComponent('ongkir') }}
                    </div>
                    <div>
                        {{ $this->form->getComponent('diskon') }}
                    </div>
                    <div>
                        {{ $this->form->getComponent('grand_total') }}
                    </div>
                </div>
            </x-filament::card>
        </div>
    </div>
@endsection
