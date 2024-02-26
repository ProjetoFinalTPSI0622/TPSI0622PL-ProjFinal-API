<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $now = Carbon::now();

        DB::table('tickets')->insert([
            'createdby' => 1,
            'assignedto' => null,
            'title' => 'Problema de rede',
            'description' => 'Usuário relatou problemas de conexão com a rede interna.',
            'status' => 1,
            'priority' => 2,
            'category' => 1,
            'location' => 2,
            'closed_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 2,
            'assignedto' => null,
            'title' => 'Solicitação de novo recurso',
            'description' => 'Usuário solicitou a adição de um novo recurso ao sistema.',
            'status' => 1,
            'priority' => 3,
            'category' => 2,
            'location' => 1,
            'closed_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('tickets')->insert([
            'createdby' => 3,
            'assignedto' => null,
            'title' => 'Erro na aplicação móvel',
            'description' => 'Usuário relatou um erro ao tentar fazer login no aplicativo móvel.',
            'status' => 1,
            'priority' => 2,
            'category' => 1,
            'location' => 3,
            'closed_at' => null,
            'created_at' => $now->subDays(3),
            'updated_at' => $now->subDays(1),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 4,
            'assignedto' => null,
            'title' => 'Problema com o pagamento online',
            'description' => 'Usuário está enfrentando dificuldades ao tentar fazer um pagamento online.',
            'status' => 1,
            'priority' => 3,
            'category' => 1,
            'location' => 2,
            'closed_at' => null,
            'created_at' => $now->subDays(5),
            'updated_at' => $now->subDays(2),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 5,
            'assignedto' => null,
            'title' => 'Problema com o ar-condicionado na Sala 101',
            'description' => 'Usuário relata que o ar-condicionado da Sala 101 não está funcionando corretamente, tornando o ambiente desconfortável.',
            'status' => 1,
            'priority' => 1,
            'category' => 1,
            'location' => 1,
            'closed_at' => null,
            'created_at' => $now->subDays(7),
            'updated_at' => $now->subDays(4),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 6,
            'assignedto' => null,
            'title' => 'Lâmpada queimada na sala de reuniões',
            'description' => 'Usuário relata que uma das lâmpadas da sala de reuniões está queimada, dificultando a realização de reuniões no local.',
            'status' => 3,
            'priority' => 2,
            'category' => 2,
            'location' => 3,
            'closed_at' => null,
            'created_at' => $now->subDays(10),
            'updated_at' => $now->subDays(6),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 7,
            'assignedto' => null,
            'title' => 'Manutenção do ar-condicionado central',
            'description' => 'Usuário solicita manutenção preventiva no sistema de ar-condicionado central do prédio.',
            'status' => 1,
            'priority' => 3,
            'category' => 2,
            'location' => 1,
            'closed_at' => null,
            'created_at' => $now->subDays(15),
            'updated_at' => $now->subDays(9),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 4,
            'assignedto' => null,
            'title' => 'Problema de vazamento no sistema de irrigação do jardim',
            'description' => 'Usuário relata um vazamento no sistema de irrigação do jardim principal, causando desperdício de água.',
            'status' => 1,
            'priority' => 2,
            'category' => 3,
            'location' => 2,
            'closed_at' => null,
            'created_at' => $now->subDays(20),
            'updated_at' => $now->subDays(13),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 3,
            'assignedto' => null,
            'title' => 'Problema com o projetor da Sala de Conferências',
            'description' => 'Usuário relata que o projetor da Sala de Conferências não está funcionando corretamente, dificultando a realização de apresentações.',
            'status' => 1,
            'priority' => 1,
            'category' => 1,
            'location' => 2,
            'closed_at' => null,
            'created_at' => $now->subDays(25),
            'updated_at' => $now->subDays(18),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 4,
            'assignedto' => null,
            'title' => 'Reparo na porta de acesso principal',
            'description' => 'Usuário relata que a porta de acesso principal está emperrada e precisa de reparo urgente.',
            'status' => 1,
            'priority' => 2,
            'category' => 2,
            'location' => 1,
            'closed_at' => null,
            'created_at' => $now->subDays(30),
            'updated_at' => $now->subDays(22),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 5,
            'assignedto' => null,
            'title' => 'Limpeza dos canteiros do jardim',
            'description' => 'Usuário solicita limpeza e manutenção dos canteiros do jardim, pois estão com excesso de ervas daninhas.',
            'status' => 1,
            'priority' => 3,
            'category' => 3,
            'location' => 3,
            'closed_at' => null,
            'created_at' => $now->subDays(35),
            'updated_at' => $now->subDays(28),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 6,
            'assignedto' => null,
            'title' => 'Problema com o sistema de iluminação do auditório',
            'description' => 'Usuário relata que algumas luzes do auditório estão piscando intermitentemente, causando desconforto visual durante as apresentações.',
            'status' => 1,
            'priority' => 2,
            'category' => 1,
            'location' => 3,
            'closed_at' => null,
            'created_at' => $now->subDays(5),
            'updated_at' => $now->subDays(2),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 7,
            'assignedto' => null,
            'title' => 'Troca de lâmpadas queimadas nos corredores',
            'description' => 'Usuário solicita a troca de lâmpadas queimadas nos corredores do prédio, pois estão causando áreas escuras e aumentando o risco de acidentes.',
            'status' => 2,
            'priority' => 3,
            'category' => 2,
            'location' => 1,
            'closed_at' => null,
            'created_at' => $now->subDays(10),
            'updated_at' => $now->subDays(6),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 8,
            'assignedto' => null,
            'title' => 'Problema no sistema de rega do jardim interno',
            'description' => 'Usuário relata que o sistema de rega automática do jardim interno não está funcionando corretamente, deixando algumas áreas do jardim sem irrigação.',
            'status' => 1,
            'priority' => 1,
            'category' => 3,
            'location' => 2,
            'closed_at' => null,
            'created_at' => $now->subDays(15),
            'updated_at' => $now->subDays(9),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 5,
            'assignedto' => null,
            'title' => 'Manutenção do sistema de climatização',
            'description' => 'Usuário solicita uma revisão no sistema de climatização central do prédio, pois a temperatura não está sendo regulada corretamente.',
            'status' => 1,
            'priority' => 2,
            'category' => 2,
            'location' => 1,
            'closed_at' => null,
            'created_at' => $now->subDays(20),
            'updated_at' => $now->subDays(13),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 6,
            'assignedto' => null,
            'title' => 'Instalação de novos equipamentos na Sala de Conferências',
            'description' => 'Usuário solicita a instalação de novos equipamentos audiovisuais na Sala de Conferências para melhorar as apresentações.',
            'status' => 1,
            'priority' => 1,
            'category' => 1,
            'location' => 3,
            'closed_at' => null,
            'created_at' => $now->subDays(25),
            'updated_at' => $now->subDays(18),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 7,
            'assignedto' => null,
            'title' => 'Reparo na porta de emergência do corredor C',
            'description' => 'Usuário relata que a porta de emergência do corredor C está com problemas de fechamento automático e solicita reparo imediato.',
            'status' => 2,
            'priority' => 2,
            'category' => 2,
            'location' => 1,
            'closed_at' => null,
            'created_at' => $now->subDays(30),
            'updated_at' => $now->subDays(22),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 8,
            'assignedto' => null,
            'title' => 'Podas de árvores no jardim externo',
            'description' => 'Usuário solicita podas de árvores no jardim externo do prédio para manter a área segura e esteticamente agradável.',
            'status' => 1,
            'priority' => 3,
            'category' => 3,
            'location' => 2,
            'closed_at' => null,
            'created_at' => $now->subDays(35),
            'updated_at' => $now->subDays(28),
        ]);

        DB::table('tickets')->insert([
            'createdby' => 5,
            'assignedto' => null,
            'title' => 'Atualização do sistema de segurança',
            'description' => 'Usuário solicita uma atualização no sistema de segurança do prédio para garantir a proteção adequada de todos os ocupantes.',
            'status' => 1,
            'priority' => 1,
            'category' => 2,
            'location' => 1,
            'closed_at' => null,
            'created_at' => $now->subDays(40),
            'updated_at' => $now->subDays(31),
        ]);
    }
}
