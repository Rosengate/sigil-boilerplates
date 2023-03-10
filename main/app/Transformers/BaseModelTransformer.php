<?php

namespace App\Transformers;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;

class BaseModelTransformer extends TransformerAbstract
{
    /**
     * @param BaseModel $employee
     * @return array
     */
    public function transform($employee)
    {
        if (method_exists($this, 'handle')) {
            $arr = call_user_func_array([$this, 'handle'], [$employee]);

            return array_merge(['id' => $employee->id], $arr, ['created_at' => $employee->created_at, 'updated_at' => $employee->updated_at]);
        }

        return $employee->toArray();
    }

//    /**
//     * @param Scope $scope
//     * @param string $includeName
//     * @param BaseModel $data
//     * @return false|\League\Fractal\Resource\ResourceInterface|void
//     */
//    protected function callIncludeMethod(Scope $scope, string $includeName, $data)
//    {
//        // Check if the method name actually exists
//        $methodName = 'include'.str_replace(
//                ' ',
//                '',
//                ucwords(str_replace(
//                    '_',
//                    ' ',
//                    str_replace(
//                        '-',
//                        ' ',
//                        $includeName
//                    )
//                ))
//            );
//
//        if (method_exists($this, $methodName))
//            return parent::callIncludeMethod($scope, $includeName, $data);
//
//        $transformer = static::getTransformerIfExist($data->{$includeName});
//
//        if ($transformer) {
//            return $this->item()
//        }
//    }

    public static function getTransformerIfExist($model)
    {
        if (!$model)
            return null;

        $transformer = null;

        if ($model instanceof BaseModel) {
            $class = $model::class;
            $class = str_replace('Model', 'Transformer', $class);

            if (class_exists($class))
                $transformer = $class;
        }

        if ($model instanceof Collection) {
            if (($first = $model->first()) && $first instanceof BaseModel) {
                $class = $first::class;
                $class = str_replace('Model', 'Transformer', $class);

                if (class_exists($class))
                    $transformer = $class;
            }
        }

        return $transformer;
    }
}
