<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Enums\EnumHelper;
use App\Models\Partner;
use App\Services\PartnerService;
use App\Traits\FileValidation;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class Create extends Component
{
    use FileValidation;
    use Toast;
    use WithFileUploads;

    /**
     * @var array<int, array{display: string, value: string}>
     */
    public array $availableStatuses = [];

    public string $contact_person;

    public string $description;

    public string $email;

    public ?TemporaryUploadedFile $logo = null;

    public ?string $logo_path = '';

    public string $name;

    public string $phone_number;

    public string $status;

    public string $type;

    public string $website;

    public bool $isCreateOpen = false;

    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService): void
    {
        $this->partnerService = $partnerService;
    }

    #[On('open-create')]
    public function setUpModal(): void
    {
        $this->reset();
        $this->authorize('create', Partner::class);

        $this->logo_path = '';
        $this->resetErrorBag();
        $this->render();

        $this->availableStatuses = EnumHelper::getStatuses();
        $this->isCreateOpen = true;
    }

    public function save(): void
    {
        $this->authorize('create', Partner::class);

        $data = $this->validate(
            array_merge(
                Partner::validationRulesCreation(),
                [
                    'logo' => [
                        'nullable',
                        'image',
                        'max:10240',
                    ],
                ]
            ),
            [
                'logo.max' => 'The file must not be larger than 10MB',
            ]
        );

        $this->logo_path = '';
        $this->dispatch('close-create');

        try {
            if ($this->logo !== null) {
                $this->validateFileNameLength($this->logo, 'logo'); // @phpstan-ignore-next-line false positive
                $this->logo_path = $this->logo->store('logos', 'public') ?: null;
            }

            $this->partnerService->createPartner(array_merge($data, ['logo_path' => $this->logo_path]));
            $this->cleanUpSuccessfully();
        } catch (Exception $exception) {
            $this->error(
                title: 'Oops! An error occurred',
                description: substr($exception->getMessage(), 0, 100).'...'
            );
        }
    }

    public function cleanUpSuccessfully(): void
    {
        $this->dispatch('update-partners-list');
        $this->reset();

        $this->isCreateOpen = false;

        $this->toast(
            type: 'success',
            title: 'Partner added!',
            icon: 'o-check-circle',
            css: 'text-sm bg-green-50 border border-green-800 text-green-800 shadow-sm',
        );
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|Application
    {
        return view('livewire.pages.internal.partner.create');
    }
}
