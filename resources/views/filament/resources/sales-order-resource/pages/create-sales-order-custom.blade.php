{{-- @extends('filament::page')

@section('content') --}}
<div class="grid grid-cols-1 gap-4">
    <div class="form-section">
        {{ $this->form }}
    </div>

    <div class="relation-manager-section">

        {{-- @livewire($relationManager, ['ownerRecord' => $record]) --}}
    </div>

    <div class="additional-form-section">
        <x-filament::card>
            <h1>Total</h1>
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

                {{-- @foreach ($this->secondaryForm->getSchema() as $component)
                    <div>
                        {{ $component->render() }}
                    </div>
                @endforeach --}}
            </div>
        </x-filament::card>
    </div>
</div>
{{-- @endsection --}}
