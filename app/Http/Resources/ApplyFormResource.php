<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplyFormResource extends JsonResource
{
    var $field0 = [
        'type' => 'html',
        'content' => '<img src="https://jobs.kissdigital.com/kiss/images/kiss.png" alt="KISS digital logo" style="display:block;margin:0 auto;margin-bottom:40px;">'
    ];

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

    var $field11 = [
        'type' => 'html',
        'content' => '<small style="display:block;text-align: center;"><br /><br /><br /><a href="https://kissdigital.com/jobs">Powrót do ofert pracy</a> | <a href="mailto:jobs@kissdigital.com">jobs@kissdigital.com</a></small>',
    ];

    var $field12 = [
        'type' => 'button',
        'label' => 'WYŚLIJ ZGŁOSZENIE'
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
            'data' => $this->form,
            $this->field0,
            $this->field0a,
            [
                'type' => 'text',
                'component' => 'h1',
                'content' => $this->job_title,
            ],
            $this->field1,
        ];

        foreach ($this->formFields as $formField) {
            $fields[] = [
                'name' => $formField->name,
                'label' => $formField->label,
                'system' => $formField->system,
                'type' => $formField->type,
                'required' => $formField->required,
            ];
        }


        $fields[] = $this->field2;
        $fields[] = $this->field12;
        $fields[] = $this->field11;

        return [
            'job_title' => $this->job_title,
            'elements' => $fields
        ];
    }
}
