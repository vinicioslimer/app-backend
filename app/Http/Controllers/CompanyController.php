<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
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
        return response()->json(['companies' => $companies]);

        //caso não encontre nenhuma empresa
        if (!$companies) {
            return response()->json(['message' => 'Companies not found'], 404);
        }

    }

    /**
     * Exibe uma empresa específica.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
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
     * @param string $id
     * @return JsonResponse
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        //valida a requisição
        $data = $request->validated();

        $company = Company::create($data);
        return response()->json(['data' => $company], 201);

        //caso não consiga criar a empresa
        if (!$company) {
            return response()->json(['message' => 'Company not created'], 404);
        }
    }

    /**
     * Atualiza um registro de empresa específica.
     *
     * @param CompanyRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CompanyRequest $request, $id): JsonResponse
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        $data = $request->validated();
        $company->update($data);

        return response()->json(['data' => $company], 200);
    }

    /**
     * Remove a empresa especificada do registro.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        // Exclui a foto atrelada a empresa, se ela existir
        if ($company->photo) {
            Storage::disk('public')->delete($company->photo);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted'], 204);
    }
}
