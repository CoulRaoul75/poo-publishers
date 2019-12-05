<?php


namespace M2i\monProjet\Model;


use mysql_xdevapi\Exception;

class PublisherDAO
{
    // instance de PDO
    // Antislash > voulu car PDO existe à la racine des fichiers PHP
    // Antislash > signifie que ce n'est pas à la racine de namespace
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * PublisherDAO constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findOneById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM publishers WHERE id=?");
        $statement->execute([$id]);
        return $statement->fetch(\PDO::FETCH_ASSOC);

    }
// ou bien fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Publisher"); ??
    public function findAll()
    {
        $statement = $this->pdo->prepare("SELECT id AS idPublisher, name AS namePublisher FROM publishers");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function deleteOne($id)
    {
         $statement = $this->pdo->prepare("DELETE FROM publishers WHERE id = ?");
         $statement->execute([$id]);
         $statement->rowCount();
         return $statement->fetch(\PDO::FETCH_ASSOC);
    }

}





