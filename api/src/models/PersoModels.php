<?php

class PersoModels
{
  private $bdd;

  public function __construct($bdd)
  {
    $this->bdd = $bdd;
  }

  public function persoAdd($persoData)
  {
    $query = "INSERT INTO persos (
      pseudo, 
      title, 
      class, 
      stat_force,
      stat_dexterity,
      stat_luck,
      stat_intelligence,
      stat_knowledge
    ) VALUES (
      :pseudo, 
      :title, 
      :class, 
      :stat_force,
      :stat_dexterity,
      :stat_luck,
      :stat_intelligence,
      :stat_knowledge
    )";

    $stmt = $this->bdd->prepare($query);

    $stmt->bindParam(':pseudo', $persoData['pseudo']);
    $stmt->bindParam(':title', $persoData['title']);
    $stmt->bindParam(':class', $persoData['class']);
    $stmt->bindParam(':stat_force', $persoData['stats']['force']);
    $stmt->bindParam(':stat_dexterity', $persoData['stats']['dexterity']);
    $stmt->bindParam(':stat_luck', $persoData['stats']['luck']);
    $stmt->bindParam(':stat_intelligence', $persoData['stats']['intelligence']);
    $stmt->bindParam(':stat_knowledge', $persoData['stats']['knowledge']);

    try {
      $stmt->execute();
      return $this->bdd->lastInsertId();
    } catch (PDOException $e) {
      $logger = new Logs();
      $logger->error("Erreur lors de l'ajout du personnage : " . $e->getMessage());
      throw new Exception("Erreur lors de l'ajout du personnage : " . $e->getMessage());
    }
  }

  public function persoGetById($id)
  {
    $query = "SELECT * FROM persos WHERE id = :id";
    $stmt = $this->bdd->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function persoGetAll()
  {
    $query = "SELECT * FROM persos";
    $stmt = $this->bdd->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function persoUpdate($id, $persoData)
  {
    $query = "UPDATE persos SET";

    foreach ($persoData as $key => $value) {
      if (is_array($value)) {
        foreach ($value as $subKey => $subValue) {
          $query .= " {$key}_{$subKey} = :{$key}.{$subKey},";
        }
      } else {
        $query .= " {$key} = :{$key},";
      }
    }

    $query = rtrim($query, ',');
    $query .= " WHERE id = :id";

    $stmt = $this->bdd->prepare($query);

    foreach ($persoData as $key => $value) {
      if (is_array($value)) {
        foreach ($value as $subKey => $subValue) {
          $stmt->bindParam(':{$key}.{$subKey}', $subValue);
        }
      } else {
        $stmt->bindParam(':{$key}', $value);
      }
    }

    $stmt->bindParam(':id', $id);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      $logger = new Logs();
      $logger->error("Erreur lors de la mise à jour du personnage : " . $e->getMessage());
      throw new Exception("Erreur lors de la mise à jour du personnage : " . $e->getMessage());
    }
  }

  public function persoDelete($id)
  {
    $query = "DELETE FROM persos WHERE id = :id";
    $stmt = $this->bdd->prepare($query);
    $stmt->bindParam(':id', $id);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      $logger = new Logs();
      $logger->error("Erreur lors de la suppression du personnage : " . $e->getMessage());
      throw new Exception("Erreur lors de la suppression du personnage : " . $e->getMessage());
    }
  }
}
