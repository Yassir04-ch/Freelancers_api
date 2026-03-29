<?php 
namespace App\Services;

use App\Models\Technology;
use App\Repositories\TechnologieRepository;

class TechnologieService{

   private $repository;

   public function __construct(TechnologieRepository $repository)
   {
    $this->repository = $repository;
   }

    public function technologies()
    {
       $technology =  $this->repository->technologies();
       return $technology;
    }

    public function createTechnology(string $name)
    {
        $technology = Technology::where('name', $name)->first();
        if ($technology) {
            return ['success' => false, 'message' => 'technologie déja created', 'code' => 422];
        }

        $this->repository->createTechnology($name);
        return ['success' => true, 'message' => 'technologie a été ajouté', 'code' => 201];
    }

    public function deleteTechnology(Technology $technology)
    {
        $this->repository->deleteTechnology($technology);
        return ['success' => true, 'message' => 'technologie est supprimé', 'code' => 200];
    }
}