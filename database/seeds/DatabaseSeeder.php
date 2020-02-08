<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('test123'),
        ]);

        $stages = [1 => 'Nowy', 2 => 'Analiza CV', 3 => 'Rozmowa telefoniczna', 4 => 'Spotkanie', 5 => 'Odrzucenie po CV', 6 => 'Odrzucenie po telefonie', 7 => 'Odrzucenie po spotkaniu', 8 => 'Złożenie oferty', 9 => 'Zatrudnienie', 9 => 'Rezygnacja kandydata'];

        foreach ($stages as $key => $val)
        {
            DB::table('stages')->insert([
                'id' => $key,
                'name' => $val
            ]);
        }

        DB::table('stage_message_templates')->insert([
            'stage_id' => 1,
            'subject' => 'RE: {NAZWA_STANOWISKA} w KISS digital sp. z o.o.',
            'body' => "Dzień dobry,\n\nDziękuję za złożenie swojej aplikacji na stanowisko Junior iOS Developer. Na bieżąco zapoznaję się z otrzymywanymi ofertami, więc już niebawem wrócę z informacją na temat wyniku pierwszego etapu rekrutacji. W przypadku pozytywnej weryfikacji będę się chciał umówić na rozmowę telefoniczną; jeżeli wynik będzie negatywny, także wyślę stosowną informację.\n\npozdrawiam\nAdam Kubiczek\nKISS digital sp. z o.o."
        ]);

        DB::table('stage_message_templates')->insert([
            'stage_id' => 3,
            'subject' => 'RE: {NAZWA_STANOWISKA} w KISS digital sp. z o.o.',
            'body' => "Dzień dobry,\n\nDziękuję za przesłanie swojej oferty. Chciałbym się umówić na rozmowę telefoniczną w czasie której poruszymy ogólnie kwestie związane z programowaniem na iOS. Rozmowa powinna potrwać nie więcej niż 20 minut. Czy możemy się umówić na {DATA_SPOTKANIA} o godzinie {GODZINA_SPOTKANIA}?\n\nJeżeli ten termin nie jest dogodny, proszę o zaproponowanie innej godziny.\n\npozdrawiam\nAdam Kubiczek\nKISS digital sp. z o.o."
        ]);

        DB::table('stage_message_templates')->insert([
            'stage_id' => 4,
            'subject' => 'RE: {NAZWA_STANOWISKA} w KISS digital sp. z o.o.',
            'body' => "Dzień dobry,\n\nDziękuję za poświęcony czas i rozwiązanie testu telefonicznego. Jego wynik był na tyle odpowiedni, aby zakwalifikować się do drugiego etapu. W związku z tym chciałbym zaprosić Pana na spotkanie u nas w biurze, w trakcie którego będziemy mieli okazję się poznać osobiście i porozmawiać na tematy „miękkie” jak również rozwiązać kilka zadań praktycznych. Spotkanie powinno potrwać nie dłużej niż 75 minut - czy możliwe jest ono {DATA_SPOTKANIA} o godzinie {GODZINA_SPOTKANIA}?\n\npozdrawiam\nAdam Kubiczek\nKISS digital sp. z o.o."
        ]);

        DB::table('stage_message_templates')->insert([
            'stage_id' => 6,
            'subject' => 'RE: {NAZWA_STANOWISKA} w KISS digital sp. z o.o.',
            'body' => "Dzień dobry,\n\nDziękuję za poświęcony czas i rozwiązanie testu telefonicznego. Niestety jego wynik był na chwilę obecną zbyt słaby, aby zakwalifikować się do drugiego etapu. Jednakże zachęcam do udziału w kolejnych rekrutacjach i życzę powodzenia.\n\npozdrawiam\nAdam Kubiczek\nKISS digital sp. z o.o."
        ]);

        DB::table('stage_message_templates')->insert([
            'stage_id' => 7,
            'subject' => 'RE: {NAZWA_STANOWISKA} w KISS digital sp. z o.o.',
            'body' => "Dzień dobry,\n\nPanie XXXXXXX, dziękuję za spotkanie i miłą rozmowę u nas w biurze. Niestety na chwilę obecną nie zdecyduję się na Pańską ofertę - wynika to z faktu, że wynik z testów praktycznych nie był odpowiednio wysoki. Pozwolę sobie zachować jednak Pańskie CV i odezwę się prawdopodobnie przy kolejnej rekrutacji.\n\npozdrawiam\nAdam Kubiczek\nKISS digital sp. z o.o."
        ]);
    }
}
