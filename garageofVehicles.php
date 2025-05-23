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

abstract class Vehicles
{
    protected $serialNumber;
    protected $ratio;
    protected $distance;
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }
    public function getRatio()
    {
        return $this->ratio;
    }
    public function getDistance()
    {
        return $this->distance;
    }
    public function setSerialNumber($serialNumber)
    {
        if (empty(trim(($serialNumber)))) {
            die("Serial number field can't be empty.");
        }   
        $this->serialNumber = $serialNumber;
    }
    public function setRatio(float $ratio)
    {
        if ($ratio < 0 || $ratio > 15) {
            die("Ratio value is't valid.");
        }
        $this->ratio = $ratio;
    }
    public function setDistance($distance)
    {
        if ($distance < 0){
            die("The distance field must have a positive value.");
        }
        $this->distance = $distance;
    }
    public function __construct(array $data)
    {
        if (isset($data["serialNumber"])) {
            $this->setSerialNumber($data["serialNumber"]);
        }
        if (isset($data["ratio"])) {
            $this->setRatio($data["ratio"]);
        }
        if (isset($data["distance"])) {
            $this->setDistance($data["distance"]);
        }
    }
}

class Car extends Vehicles implements Vehicle
{
    public function display()
    {
        echo "Car with serial number " . $this->getSerialNumber() . ", traveled " . $this->getDistance() . " km today. <br>";
    }
    public function consumedFuel()
    {
        $consumedFuel = ($this->getDistance() / 100) * $this->getRatio();
        return $consumedFuel;
    }
}

class Truck extends Vehicles implements Vehicle
{
    protected $cargo;

    public function getCargo()
    {
        return $this->cargo;
    }
    public function setCargo($cargo)
    {
        if ($this->cargo > 15) {
            die("Prekoracen maksimalni teret.");
        }
        $this->cargo = $cargo;
    }
    public function __construct(array $data)
    {
        parent::__construct($data);
        if (isset($data["cargo"])) {
            $this->setCargo($data["cargo"]);
        }
    }
    public function display()
    {
        echo "Truck with serial number " . $this->getSerialNumber() . " transported " . $this->getCargo() . " tons of cargo today. <br>";
    }
    public function consumedFuel()
    {
        $newRatio = round($this->getCargo(), 2) + $this->getRatio();
        $consumedFuel = ($this->getDistance() / 100) * $newRatio;
        return $consumedFuel;
    }
}

class Bus extends Vehicles implements Vehicle, HasRoute
{
    protected $passengers;
    protected $route;
    public function getRoute()
    {
        return $this->route;
    }
    public function setRoute(string $route)
    {
        if (trim($this->route) === ""){
            die("The route entry field must be filled in.");
        }
        $this->route = $route;
    }
    public function getPassengers()
    {
        return $this->passengers;
    }
    public function setPassengers($passengers)
    {
        if($passengers < 0 || $passengers > 80){
            die("Passenger field is invalid.");
        }
        $this->passengers = $passengers;
    }
    public function __construct(array $data)
    {
        parent::__construct($data);
        if (isset($data["passengers"])) {
            $this->setPassengers($data["passengers"]);
        }
        if (isset($data["route"])) {
            $this->setRoute($data["route"]);
        }
    }
    public function display()
    {
        echo "Autobus, serijskog broja " . $this->getSerialNumber() . " danas je prevezao " . $this->getPassengers() . " putnika. <br>";
    }
    public function consumedFuel()
    {
        $newRatio = $this->getPassengers() + $this->getRatio();
        $consumedFuel = ($this->getDistance() / 100) * $newRatio;
        return $consumedFuel;
    }
}

$garage01 = new Garage();
$garage01->addVehicles(new Car([
    "serialNumber" => "123456",
    "ratio" => "5",
    "distance" => "50"
]))->addVehicles(new Bus([
    "serialNumber" => "741852",
    "ratio" => "7",
    "distance" => "250",
    "passengers" => "44",
    "route" => "Beograd-Sombor"
]))->addVehicles(new Bus([
    "serialNumber" => "25452",
    "ratio" => "8",
    "distance" => "320",
    "passengers" => "41",
    "route" => "Beograd-Nis"
]));

$garage01->listVehicles();
$garage01->fuelReport();

$busStation01 = new BusStation();
$busStation01->addBus(new Bus([
    "serialNumber" => "25452",
    "ratio" => "8",
    "distance" => "320",
    "passengers" => "41",
    "route" => "Beograd-Nis"
]))->addBus(new Bus([
    "serialNumber" => "741852",
    "ratio" => "7",
    "distance" => "250",
    "passengers" => "44",
    "route" => "Beograd-Sombor"
]));
$busStation01->displayRoutes();
