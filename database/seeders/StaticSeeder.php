<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('static_sites')->insert([
            [
                'name' => 'O nas',
                'contents' => '<p>Firma BAJ-SOFT została założona w roku 1998r. Od początku działalności naszym celem jest rozpowszechnianie skutecznych rozwiązań informatycznych. Nasze działania opierają się na wiedzy i doświadczeniu zarówno z informatyki jak i zarządzania przedsiębiorstwami. Naszym klientom oferujemy zarówno stałą obsługę, jak również wykonujemy zlecenia jednorazowe.<br>
                Specjalizujemy się we wdrażaniu rozwiązań firm takich jak Microsoft (systemy operacyjne, oprogramowanie biurowe, oprogramowanie serwerowe), Soneta (oprogramowanie dla przedsiębiorstw enova365), G Data (oprogramowanie antywiurusowe i z zakresu bezpieczeństwa) oraz wielu innych.<br>
                Naszym klientom jesteśmy również w stanie dostarczyć sprzęt lub doradzić w jego doborze.<br>
                Obecnie firma nasza świadczy kompleksowe usługi w zakresie informatyki. W szczególności zajmujemy się:</p>
                <ul>
                <li>Wykonywaniem oprogramowania na zamówienie</li>
                <li>Projektowaniem stron i aplikacji internetowych</li>
                <li>Wdrażaniem i obsługą programu enova365.</li>
                <li>Programowaniem dodatków dla programu enova365.</li>
                <li>Administracją sieci i systemów komputerowych</li>
                <li>Kompleksową obsługą informatyczną firm</li>
                <li>Usługami doradczymi z zakresu informatyki</li>
                <li>Projektowaniem i wykonawstwem instalacji sieci teleinformatycznych</li>
                <li>Projektowaniem systemów zasilania awaryjnego</li>
                </ul>
                <p>Od kilku lat ściśle współpracujemy z firmą <a href="https://erpit.pl" target="_blank">ERPIT Sp. z o.o.</a> i realizujemy dla niej zadania z zakresu realizacji oprogramowania i wdrożeń oprogramowania enova365.</p>',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Misja',
                'contents' => '<p>Firma BAJ-SOFT od początku działalności wspiera klientów w zakresie technologii informatycznych. Naszym celem jest usprawnianie funkcjonowania przedsiębiorstw za pomocą rozwiązań informatycznych, a w szczególności systemów ERP.&nbsp;W naszych działaniach wspieramy kształcenie młodych ludzi poprzez zatrudnianie zdolnych studentów, a także prowadzenie praktyk dla studentów uczelni technicznych.</p>
                <p>Od roku 2019 przystąpiliśmy do programu studiów dualnych realizowanych przez Państwową Wyższą Szkołę Zawodową im. J. A. Komeńskiego w Lesznie i wkrótce szeregi naszej kadry zasilą studenci realizujący praktykę w ramach tego programu.</p>',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
