<?php

/**
 * A garage that has vehicles for transportation and has certain methods for easier work
 */
class Garage
{
    protected array $vehicles;
    /**
     * Vehicle display method
     * @return void
     */
    public function listVehicles()
    {
        foreach ($this->vehicles as $vehicle) {
            $vehicle->display();
        }
        echo "<hr>";
    }
    /**
     * Vehicle fuelReport methode
     * @return
     */
    public function fuelReport()
    {
        $sum = 0;
        foreach ($this->vehicles as $vehicle) {
            $sum += $vehicle->consumedFuel();
            echo "Vozilo serijski broj " . $vehicle->getSerialNumber() . " potrosilo je " . $vehicle->consumedFuel() . " l. <br>";
        }
        echo "Ukupna potrosnja goriva je " . $sum . "<hr>";
    }
    /**
     * 
     * @param Vehicle $vehicle
     * @return 
     */
    public function addVehicles(Vehicle $vehicle)
    {
        $this->vehicles[] = $vehicle;
        return $this;
    }
}

class BusStation
{
    protected array $buses;
    /**
     * bus route display methode
     * @return void
     */
    public function displayRoutes()
    {
        echo "Avaliable bus routes: <br><hr>";
        foreach ($this->buses as $bus) {
            echo $bus->getRoute() . "<br><hr>";
        }
    }
    /**
     * a method that adds new buses to the array must have an implementation of the HashRoute interface
     * @param HasRoute $bus
     * @return static
     */
    public function addBus(HasRoute $bus)
    {
        $this->buses[] = $bus;
        return $this;
    }
}

interface HasRoute
{
    public function getRoute();
}
interface Vehicle
{
    public function display();
    /**
     * Summary of consumedFuel
     * @return
     */
    public function consumedFuel();
}
