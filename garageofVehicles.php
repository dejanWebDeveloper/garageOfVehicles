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
