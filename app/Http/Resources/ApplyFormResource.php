<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplyFormResource extends JsonResource
{
    var $field0a = [
        'type' => 'text',
        'component' => 'h2',
        'content' => 'Aplikujesz na stanowisko'
    ];

    var $field1 = [
        'type' => 'text',
        'content' => 'Jest nam niezmiernie miło, że zamierzasz dołączyć do naszego zespołu. Aby rozpocząć proces rekrutacji, wypełnij poniższy formularz i załącz swoje CV. Odezwiemy się tak szybko, jak to możliwe.'
    ];

    var $field2 = [
        'type' => 'text',
        'component' => 'small',
        'content' => 'Administratorem danych osobowych jest KISS digital sp. z o.o. z siedzibą w Krakowie przy ul. Łobzowskiej 20/7. Dane osobowe będą przetwarzane w celu realizacji procesu rekrutacji przez czas niezbędny na jego przeprowadzenie.<br /><br />Jeżeli wyrazi Pani/Pan dobrowolną zgodę na przetwarzanie danych w celu prowadzenia przyszłych rekrutacji dane będą przetwarzane przez okres 4 lat. W razie cofnięcia zgody na przyszłe rekrutacje dane te zostaną niezwłocznie usunięte.<br /><br />Przewidywanymi odbiorcami danych są pracownicy działu HR oraz kadra kierownicza decydująca o zatrudnieniu.<br /><br />Przysługuje Pani/Panu prawo do żądania od administratora dostępu do danych osobowych dotyczących swojej osoby, ich sprostowania, usunięcia lub ograniczenia przetwarzania (w tym zmiany zgód). Przysługuje Pani/Panu także prawo wniesienia skargi do organu nadzorczego (Prezesa Urzędu Ochrony Danych Osobowych albo Generalnego Inspektora Ochrony Danych Osobowych).'
    ];

    var $field3 = [
        'type' => 'text_input',
        'name' => 'first_name',
        'label' => 'Imię',
        'required' => true
    ];

    var $field4 = [
        'type' => 'text_input',
        'name' => 'last_name',
        'label' => 'Nazwisko',
        'required' => true
    ];

    var $field5 = [
        'type' => 'email_input',
        'name' => 'email',
        'label' => 'Email',
        'required' => true
    ];

    var $field6 = [
        'type' => 'phone_input',
        'name' => 'phone_number',
        'label' => 'Telefon',
        'required' => true
    ];

    var $field7 = [
        'type' => 'file',
        'name' => 'file',
        'label' => 'Wczytaj plik zawierający CV (PDF)*',
        'required' => true
    ];

    var $field8 = [
        'type' => 'text_input',
        'name' => 'additional_data',
        'multiline' => true,
        'label' => 'Dodatkowe informacje',
        'required' => false
    ];

    var $field9 = [
        'type' => 'checkbox',
        'name' => 'agreement',
        'label' => 'Wyrażam zgodę na przetwarzanie przez KISS digital sp. z o.o. moich danych osobowych na potrzeby tej rekrutacji, w tym także zgadzam się na kontaktowanie ze mną za pomocą telefonu, SMS oraz email w zakresie niezbędnym do przeprowadzanie rekrutacji.*',
        'required' => true
    ];

    var $field10 = [
        'type' => 'checkbox',
        'name' => 'future_agreement',
        'label' => 'Wyrażam zgodę na przetwarzanie przez KISS digital sp. z o.o. moich danych osobowych na potrzeby przyszłych rekrutacji.',
        'required' => false
    ];

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $fields = [
            $this->field0a,
            [
                'type' => 'text',
                'component' => 'h1',
                'content' => $this->job_title,
            ],
            $this->field1,
            $this->field3,
            $this->field4,
            $this->field5,
            $this->field6,
            $this->field7,
            $this->field8,
            $this->field9,
            $this->field10,
            $this->field2,
        ];

        return [
            'job_title' => $this->job_title,
            'elements' => $fields
        ];
    }
}
