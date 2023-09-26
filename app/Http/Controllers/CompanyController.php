<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Exibe a lista de empresas.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();

        if (!$companies->isEmpty()) {
            return response()->json(['companies' => $companies]);
        } else {
            return response()->json(['message' => 'Companies not found'], 404);
        }
    }

    /**
     * Exibe uma empresa específica.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        return response()->json(['company' => $company]);
    }

    /**
     * Cria um novo registro de empresa.
     *
     * @param CompanyRequest $request
     * @return JsonResponse
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        try {
            // Cria a empresa no banco de dados
            $company = new Company;

            $company->name = $request->name;
            $company->cnpj = $request->cnpj;
            $company->photo = $request->photo;

            $company->save();

            return response()->json(['data' => $company], 201);

        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating company: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Atualiza um registro de empresa específica.
     *
     * @param CompanyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CompanyRequest $request, int $id): JsonResponse
    {
        try {
            // Valida a requisição
            $data = $request->validated();

            $company = Company::find($id);

            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }

            // Atualiza a empresa no banco de dados
            $company->name = $request->name;
            $company->cnpj = $request->cnpj;
            $company->photo = $request->photo;

            $company->save();

            return response()->json(['data' => $company], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating company: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove a empresa especificada do registro.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        // Exclui a foto atrelada à empresa, se ela existir
        if ($company->photo) {
            Storage::disk('public')->delete($company->photo);
        }

        // Deleta a empresa
        $company->delete();

        return response()->json(['message' => 'Company deleted'], 204);
    }
}
