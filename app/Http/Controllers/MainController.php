<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private const BARBEIROS = [
        '',
        'Matheus',
        'Murilo',
        'Barbeiro Pine',
    ];

    public function index()
    {
        $agendamentos = $this->agendamentosDoVisitante()->latest('horario')->get();

        return view('inicio', [
            'barbeiros' => self::BARBEIROS,
            'agendamentos' => $agendamentos,
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_corte' => ['required', 'string', 'min:3', 'max:100'],
            'horario' => ['required', 'date'],
            'barbeiro' => ['required', 'string', 'in:' . implode(',', self::BARBEIROS)],
        ], [
            'nome_corte.required' => 'Informe o nome do corte.',
            'nome_corte.min' => 'O nome do corte deve ter pelo menos :min caracteres.',
            'horario.required' => 'Informe o horário do agendamento.',
            'horario.after' => 'Escolha um horário futuro.',
            'barbeiro.required' => 'Selecione um barbeiro.',
            'barbeiro.in' => 'Selecione um barbeiro válido.',
        ]);

        $dados['user_id'] = session('user.id');
        $dados['session_key'] = session()->getId();
        Agendamento::create($dados);

        return redirect()->route('cortes.cadastrados')->with('success', 'Corte agendado com sucesso.');
    }

    public function cortesCadastrados()
    {
        $agendamentos = $this->agendamentosDoVisitante()->latest('horario')->get();

        return view('cortesCadastradosUsuario', compact('agendamentos'));
    }

    private function agendamentosDoVisitante()
    {
        $query = Agendamento::query();

        if (session('user.id')) {
            return $query->where('user_id', session('user.id'));
        }

        return $query->whereNull('user_id')->where('session_key', session()->getId());
    }
}