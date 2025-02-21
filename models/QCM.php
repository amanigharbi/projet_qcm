
<?php require_once __DIR__ . '/../bdd/Database.php';

class ListQCM
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function recupereQCMCate($categorie)
    {

        $sql = 'SELECT  * FROM qcm WHERE categorie_id=:categorie';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['categorie' => $categorie]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }



    public function recupereQCM()
    {

        $sql = 'SELECT DISTINCT  q.titre,q.description,c.nom,c.image FROM qcm AS q INNER JOIN categories AS c ON q.categorie_id=c.id ';
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
?>
