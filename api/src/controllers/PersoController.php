<?php

class PersoController
{
  private $httpRequest;
  private $config;

  public function __construct($httpRequest, $config)
  {
    $this->httpRequest = $httpRequest;
    $this->config = $config;
  }

  public function Add($persoData)
  {
    if ($persoData) {
      try {
        $bdd = BDD::getInstance()->getBdd();
        $persoModels = new PersoModels($bdd);
        $persoId = $persoModels->persoAdd($persoData);

        header('Content-Type: application/json');
        $response = [
          'status' => 'success',
          'message' => 'Personnage créé avec succès',
          'data' => $persoId
        ];

        echo json_encode($response);
      } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
          'status' => 'error',
          'message' => $e->getMessage()
        ]);
      }
    } else {
      http_response_code(400);
      echo json_encode([
        'status' => 'error',
        'message' => 'Données invalides'
      ]);
    }
  }

  public function GetById($params)
  {
    $bdd = BDD::getInstance()->getBdd();
    $persoModels = new PersoModels($bdd);
    $perso = $persoModels->persoGetById($params['id']);

    $persoFormatted = [
      'id' => $perso['id'],
      'pseudo' => $perso['pseudo'],
      'title' => $perso['title'],
      'class' => $perso['class'],
      'stats' => [
        "force" => $perso['stat_force'],
        "dexterity" => $perso['stat_dexterity'],
        "luck" => $perso['stat_luck'],
        "intelligence" => $perso['stat_intelligence'],
        "knowledge" => $perso['stat_knowledge'],
      ],
    ];

    if ($perso) {
      header('Content-Type: application/json');
      echo json_encode($persoFormatted);
    } else {
      http_response_code(404);
      echo json_encode([
        'status' => 'error',
        'message' => 'Personnage non trouvé'
      ]);
    }
  }

  public function GetAll()
  {
    $bdd = BDD::getInstance()->getBdd();
    $persoModels = new PersoModels($bdd);
    $persos = $persoModels->persoGetAll();
    $persosFormatted = [];

    foreach ($persos as $perso) {
      $persosFormatted[] = [
        'id' => $perso['id'],
        'pseudo' => $perso['pseudo'],
        'title' => $perso['title'],
        'class' => $perso['class'],
        'stats' => [
          "force" => $perso['stat_force'],
          "dexterity" => $perso['stat_dexterity'],
          "luck" => $perso['stat_luck'],
          "intelligence" => $perso['stat_intelligence'],
          "knowledge" => $perso['stat_knowledge'],
        ],
        'created_at' => $perso['created_at'],
      ];
    }

    if ($persos) {
      header('Content-Type: application/json');
      echo json_encode($persosFormatted);
    } else {
      http_response_code(404);
      echo json_encode([
        'status' => 'error',
        'message' => 'Personnages non trouvés'
      ]);
    }
  }

  public function Update($params)
  {
    $logger = new Logs();
    $logger->logVariable($params, 'Params');
  }
}
