<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{__('Create')}}
        </x-jet-button>
    </div>
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{__('Save Page')}}
        </x-slot>
        <x-slot name="content">
            The form elements go here
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{__('Nevermind')}}
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{__('Save')}}
            </x-jet-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>
