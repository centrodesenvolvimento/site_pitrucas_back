<?php

namespace Database\Factories;

use App\Models\Departamentos;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartamentosFactory extends Factory
{
    protected $model = Departamentos::class;
    /**
     * Define the model's default state.
     *
     *
     * @return array
     */
    public function definition()
    {
        return [
            'info'=> [
                'titulo' => 'Nome_do_departamento',
                'video' => null,
                'descricao' => 'Descricao',
                'saidas' => [],
            ],
            'cursos' => [

            ],
        ];
    }
}
