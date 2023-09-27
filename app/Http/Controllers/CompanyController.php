<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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

        if ($companies->isEmpty()) {
            return response()->json(['message' => 'Companies not found'], 404);
        }

        return response()->json($companies);
    }

    /**
     * Exibe uma empresa específica.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(Company $company): JsonResponse
    {
        return response()->json($company);
    }

    /**
     * Cria um novo registro de empresa.
     *
     * @param CompanyRequest $request
     * @return JsonResponse
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        // Cria a empresa no banco de dados
        $company = new Company;

        $company->name = $request->name;
        $company->cnpj = $request->cnpj;
        $company->photo = $request->photo;

        $company->save();

        return response()->json($company, Response::HTTP_CREATED);
    }

    /**
     * Atualiza um registro de empresa específica.
     *
     * @param CompanyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Company $company, CompanyRequest $request): JsonResponse
    {
        // Atualiza a empresa no banco de dados
        $company->name = $request->name;
        $company->cnpj = $request->cnpj;
        $company->photo = $request->photo;

        $company->save();

        return response()->json($company);
    }

    /**
     * Remove a empresa especificada do registro.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Company $company): JsonResponse
    {
        // Exclui a foto atrelada à empresa, se ela existir
        if ($company->photo) {
            Storage::delete($company->photo);
        }

        // Deleta a empresa
        $company->delete();

        return response()->json(['status' => true], Response::HTTP_NO_CONTENT);
    }
}
