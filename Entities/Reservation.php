<?php

class Reservation
{

    private $id_reservation;
    private $id_user;
    private $id_evenement;
    private $date_reservation;


    /**
     * Get the value of id_reservation
     */
    public function getId_reservation()
    {
        return $this->id_reservation;
    }

    /**
     * Set the value of id_reservation
     *
     * @return  self
     */
    public function setId_reservation($id_reservation)
    {
        $this->id_reservation = $id_reservation;

        return $this;
    }

    /**
     * Get the value of id_user
     */
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get the value of id_evenement
     */
    public function getId_evenement()
    {
        return $this->id_evenement;
    }

    /**
     * Set the value of id_evenement
     *
     * @return  self
     */
    public function setId_evenement($id_evenement)
    {
        $this->id_evenement = $id_evenement;

        return $this;
    }

    
    /**
     * Get the value of date_reservation
     */
    public function getDate_reservation()
    {
        return $this->date_reservation;
    }

    /**
     * Set the value of date_reservation
     *
     * @return  self
     */
    public function setDate_reservation($date_reservation)
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }
}
