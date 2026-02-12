<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting as SiteSettingModel;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Livewire\WithFileUploads;

class SiteSetting extends Page implements HasForms
{
    use InteractsWithForms;
    use WithFileUploads;

    protected static ?string $title = 'Site Setting';

    protected static ?string $navigationLabel = 'Site Setting';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.site-setting';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getFormState());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components($this->getFormSchema());
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Branding')
                ->schema([
                    TextInput::make('site_name')
                        ->label('Site name')
                        ->maxLength(255),
                    TextInput::make('site_tagline')
                        ->label('Site tagline')
                        ->maxLength(255),
                    FileUpload::make('logo_path')
                        ->label('Logo file (For dark version)')
                        ->disk('public')
                        ->directory('logos')
                        ->image()
                        ->preserveFilenames()
                        ->helperText('Uploads to storage/app/public/logos. Ensure storage is linked.'),
                    FileUpload::make('logo_light_path')
                        ->label('Logo file (For light version)')
                        ->disk('public')
                        ->directory('logos')
                        ->image()
                        ->preserveFilenames()
                        ->helperText('Logo used when light mode is active.'),
                    FileUpload::make('favicon_path')
                        ->label('Favicon file')
                        ->disk('public')
                        ->directory('favicons')
                        ->image()
                        ->preserveFilenames()
                        ->helperText('Upload a square image or .ico file to storage/app/public/favicons.'),
                    TextInput::make('logo_alt')
                        ->label('Logo alt text')
                        ->maxLength(255),
                    TextInput::make('logo_height')
                        ->label('Logo height')
                        ->helperText('Example: 40px')
                        ->maxLength(20),
                    TextInput::make('footer_text')
                        ->label('Footer text')
                        ->maxLength(255),
                ])
                ->columns(2),
            Section::make('Contact')
                ->schema([
                    TextInput::make('contact_email')
                        ->label('Contact email')
                        ->email()
                        ->maxLength(255),
                    TextInput::make('contact_phone')
                        ->label('Contact phone')
                        ->maxLength(255),
                    TextInput::make('address')
                        ->label('Address')
                        ->maxLength(255),
                ])
                ->columns(2),
            Section::make('Social')
                ->schema([
                    TextInput::make('social_twitter')
                        ->label('Twitter/X URL')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('social_instagram')
                        ->label('Instagram URL')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('social_linkedin')
                        ->label('LinkedIn URL')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('social_facebook')
                        ->label('Facebook URL')
                        ->url()
                        ->maxLength(255),
                ])
                ->columns(2),
            Section::make('Support Links')
                ->schema([
                    TextInput::make('support_1_title')
                        ->label('Item 1 title')
                        ->maxLength(255),
                    TextInput::make('support_1_text')
                        ->label('Item 1 description')
                        ->maxLength(255),
                    TextInput::make('support_2_title')
                        ->label('Item 2 title')
                        ->maxLength(255),
                    TextInput::make('support_2_text')
                        ->label('Item 2 description')
                        ->maxLength(255),
                    TextInput::make('support_3_title')
                        ->label('Item 3 title')
                        ->maxLength(255),
                    TextInput::make('support_3_text')
                        ->label('Item 3 description')
                        ->maxLength(255),
                ])
                ->columns(2),
            Section::make('Commerce & System')
                ->schema([
                    TextInput::make('currency')
                        ->label('Currency code')
                        ->maxLength(10),
                    TextInput::make('timezone')
                        ->label('Timezone')
                        ->maxLength(255),
                ])
                ->columns(2),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $socialLinks = $this->normalizeSocialLinks($state);
        $supportLinks = $this->normalizeSupportLinks($state);

        foreach ($this->getSettingDefinitions() as $key => $definition) {
            $value = $state[$key] ?? null;
            $payload = match ($key) {
                'social_links' => $socialLinks,
                'support_links' => $supportLinks,
                default => $this->normalizeValue($key, $value),
            };

            SiteSettingModel::query()->updateOrCreate(
                ['key' => $key],
                [
                    'value' => $payload,
                    'group' => $definition['group'],
                    'description' => $definition['description'],
                ]
            );
        }

        Notification::make()
            ->title('Site settings saved')
            ->success()
            ->send();
    }

    protected function getFormState(): array
    {
        $keys = array_keys($this->getSettingDefinitions());

        $settings = SiteSettingModel::query()
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key');

        $state = [];

        foreach ($keys as $key) {
            $value = $settings[$key]->value ?? null;

            if (is_array($value) && array_key_exists('text', $value) && count($value) === 1) {
                $state[$key] = $value['text'];
                continue;
            }

            if (is_array($value)) {
                $state[$key] = json_encode($value, JSON_PRETTY_PRINT);
                continue;
            }

            $state[$key] = $value;
        }

        $socialLinks = $settings['social_links']->value ?? [];
        if (is_array($socialLinks)) {
            $state['social_twitter'] = $socialLinks['twitter'] ?? '';
            $state['social_instagram'] = $socialLinks['instagram'] ?? '';
            $state['social_linkedin'] = $socialLinks['linkedin'] ?? '';
            $state['social_facebook'] = $socialLinks['facebook'] ?? '';
        }

        $supportLinks = $settings['support_links']->value ?? [];
        if (is_array($supportLinks)) {
            $state['support_1_title'] = $supportLinks[0]['title'] ?? '';
            $state['support_1_text'] = $supportLinks[0]['text'] ?? '';

            $state['support_2_title'] = $supportLinks[1]['title'] ?? '';
            $state['support_2_text'] = $supportLinks[1]['text'] ?? '';

            $state['support_3_title'] = $supportLinks[2]['title'] ?? '';
            $state['support_3_text'] = $supportLinks[2]['text'] ?? '';
        }

        return $state;
    }

    protected function normalizeValue(string $key, mixed $value): array | null
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if ($key === 'social_links') {
            return is_array($value) ? $value : [];
        }

        return ['text' => $value];
    }


    protected function getSettingDefinitions(): array
    {
        return [
            'site_name' => [
                'group' => 'branding',
                'description' => 'Primary site name used in headers and titles.',
            ],
            'site_tagline' => [
                'group' => 'branding',
                'description' => 'Short marketing tagline for the site.',
            ],
            'logo_path' => [
                'group' => 'branding',
                'description' => 'Logo file path stored in public/ (dark mode).',
            ],
            'logo_light_path' => [
                'group' => 'branding',
                'description' => 'Logo file path stored in public/ (light mode).',
            ],
            'logo_alt' => [
                'group' => 'branding',
                'description' => 'Logo alt text for accessibility.',
            ],
            'favicon_path' => [
                'group' => 'branding',
                'description' => 'Favicon file path stored in public/.',
            ],
            'logo_height' => [
                'group' => 'branding',
                'description' => 'Logo height (e.g. 40px).',
            ],
            'footer_text' => [
                'group' => 'branding',
                'description' => 'Footer short text snippet.',
            ],
            'contact_email' => [
                'group' => 'contact',
                'description' => 'Primary contact email address.',
            ],
            'contact_phone' => [
                'group' => 'contact',
                'description' => 'Primary contact phone number.',
            ],
            'address' => [
                'group' => 'contact',
                'description' => 'Business address shown in footer and invoices.',
            ],
            'social_links' => [
                'group' => 'social',
                'description' => 'Social profile URLs used in the footer.',
            ],
            'support_links' => [
                'group' => 'support',
                'description' => 'Support links in the footer.',
            ],
            'currency' => [
                'group' => 'commerce',
                'description' => 'Default currency code for pricing displays.',
            ],
            'timezone' => [
                'group' => 'system',
                'description' => 'Primary timezone for reports and emails.',
            ],
        ];
    }

    protected function normalizeSocialLinks(array $state): array
    {
        $links = [
            'twitter' => trim((string) ($state['social_twitter'] ?? '')),
            'instagram' => trim((string) ($state['social_instagram'] ?? '')),
            'linkedin' => trim((string) ($state['social_linkedin'] ?? '')),
            'facebook' => trim((string) ($state['social_facebook'] ?? '')),
        ];

        return array_filter($links, fn (string $value) => $value !== '');
    }

    protected function normalizeSupportLinks(array $state): array
    {
        $items = [
            [
                'title' => trim((string) ($state['support_1_title'] ?? '')),
                'text' => trim((string) ($state['support_1_text'] ?? '')),
            ],
            [
                'title' => trim((string) ($state['support_2_title'] ?? '')),
                'text' => trim((string) ($state['support_2_text'] ?? '')),
            ],
            [
                'title' => trim((string) ($state['support_3_title'] ?? '')),
                'text' => trim((string) ($state['support_3_text'] ?? '')),
            ],
        ];

        return array_values(array_filter($items, function (array $item): bool {
            return $item['title'] !== '' || $item['text'] !== '';
        }));
    }
}
