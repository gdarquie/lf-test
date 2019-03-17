<?php

namespace App\Domain;


use Doctrine\ORM\EntityManagerInterface;

class ComputeRotation
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->connection = $this->em->getConnection();
    }

    /**
     * @param $nbDays
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function process()
    {
        //todo = add error and exception management
        $sql = $this->getProcedure();

        $query = 'SELECT compute_rotation()';
        $statement = $this->connection->executeQuery($query);
        $statement->fetchAll();

        return true;
    }

    /**
     * @return string
     */
    public function getProcedure()
    {

        $sql = <<< EOT
CREATE OR REPLACE FUNCTION compute_rotation()
RETURNS VOID AS $$
  DECLARE
    v_product RECORD;
    v_nb_days INT;
  BEGIN

    -- total of days from the first order to the last
    v_nb_days := (SELECT EXTRACT(DAY FROM MAX(date) - MIN(DATE)) FROM "order");

    FOR v_product IN
      SELECT * FROM product
      LOOP
        -- write the roation rate by divided sold by weeks
        UPDATE product SET rotation = (v_product.sold::DECIMAL/v_nb_days*7)::DECIMAL WHERE id = v_product.id;
      END LOOP;
  END;

$$ LANGUAGE plpgsql;
EOT;

        return $sql;
    }
}