<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Corte;
use App\Services\Operations;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $userId = session('user')['id'];
        $user = User::find($userId);

        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

        if ($user->role === 'barbeiro') {
            $query = Agendamento::where('barbeiro_id', $userId);
        } else {
            $query = Agendamento::where('cliente_id', $userId);
        }

        if ($search !== '') {
            $query->whereHas('corte', function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%");
            });
        }

        $agendamentos = $query->orderBy('data_hora', $order)
            ->paginate(9)
            ->withQueryString();

        return view('agendamentos', [
            'agendamentos' => $agendamentos,
            'search' => $search,
            'order' => $request->input('order') === 'oldest' ? 'oldest' : 'recent',
        ]);
    }

    public function create()
    {
        $userId = session('user')['id'];
        $user = User::find($userId);

        // Impede que barbeiros criem agendamentos
        if ($user && $user->role === 'barbeiro') {
            return redirect()->route('agendamentos.index')->with('error', 'Barbeiros não podem criar agendamentos.');
        }

        $barbeiros = User::where('role', 'barbeiro')->get();
        $cortes = Corte::all();

        return view('new_agendamento', compact('barbeiros', 'cortes'));
    }

    public function store(Request $request)
    {
        $userId = session('user')['id'];
        $user = User::find($userId);

        // Impede que barbeiros salvem agendamentos via requisição direta
        if ($user && $user->role === 'barbeiro') {
            return redirect()->route('agendamentos.index')->with('error', 'Barbeiros não podem criar agendamentos.');
        }

        $request->validate([
            'barbeiro_id' => 'required',
            'corte_id' => 'required',
            'data_hora' => 'required|date|after:now',
        ]);

        Agendamento::create([
            'cliente_id' => $userId,
            'barbeiro_id' => Operations::decryptId($request->barbeiro_id),
            'corte_id' => Operations::decryptId($request->corte_id),
            'data_hora' => $request->data_hora,
            'status' => 'pendente'
        ]);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento realizado com sucesso!');
    }

    public function edit($id)
    {
        $decryptedId = Operations::decryptId($id);
        $agendamento = Agendamento::find($decryptedId);

        if (!$agendamento) {
            return redirect()->route('agendamentos.index')->with('error', 'Agendamento não encontrado.');
        }

        $barbeiros = User::where('role', 'barbeiro')->get();
        $cortes = Corte::all();

        return view('edit_agendamento', compact('agendamento', 'barbeiros', 'cortes'));
    }

    public function update(Request $request, $id)
    {
        $decryptedId = Operations::decryptId($id);
        $agendamento = Agendamento::find($decryptedId);

        if (!$agendamento) {
            return redirect()->route('agendamentos.index')->with('error', 'Agendamento não encontrado.');
        }

        $request->validate([
            'barbeiro_id' => 'required',
            'corte_id' => 'required',
            'data_hora' => 'required|date',
            'status' => 'required|in:pendente,confirmado,cancelado',
        ]);

        $agendamento->update([
            'barbeiro_id' => Operations::decryptId($request->barbeiro_id),
            'corte_id' => Operations::decryptId($request->corte_id),
            'data_hora' => $request->data_hora,
            'status' => $request->status,
        ]);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $decryptedId = Operations::decryptId($id);
        $agendamento = Agendamento::find($decryptedId);

        if ($agendamento) {
            $agendamento->delete();
            return redirect()->route('agendamentos.index')->with('success', 'Agendamento cancelado com sucesso!');
        }

        return redirect()->route('agendamentos.index')->with('error', 'Agendamento não encontrado.');
    }
}