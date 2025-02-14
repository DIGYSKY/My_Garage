import { useEffect, useState } from "react";
import type { Cars } from "../form-cars/add-cars";
import axios from "axios";
import { useNavigate } from "react-router";

export function Cars() {
  const [cars, setCars] = useState<Cars[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<Error | null>(null);
  const navigate = useNavigate();

  const handleViewDocuments = (carId: number) => {
    navigate(`/car/${carId}`);
  };

  useEffect(() => {
    const fetchCars = async () => {
      try {
        const response = await axios.get("http://localhost:81/cars/:50/:0");
        if (response.data && response.data.data) {
          setCars(response.data.data);
        } else {
          throw new Error("Invalid data format received from server");
        }
        setIsLoading(false);
      } catch (err) {
        setError(err as Error);
        setIsLoading(false);
      }
    };
    fetchCars();
  }, []);

  if (isLoading) return <div>Chargement...</div>;
  if (error) return <div>Erreur: {error.message}</div>;

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">Liste des Véhicules</h1>
      <div className="grid gap-4">
        {Array.isArray(cars) && cars.map((car: Cars) => (
          <div key={car.id} className="p-4 border rounded shadow">
            <h2 className="text-lg font-bold">{car.litle_name}</h2>
            <p className="text-sm text-gray-500">{car.brand}</p>
            <p className="text-sm text-gray-500">{car.model}</p>
            <p className="text-sm text-gray-500">{car.price} €</p>
            <p className="text-sm text-gray-500">{car.first_registration_date}</p>
            {car.id !== undefined && (
              <button onClick={() => handleViewDocuments(car.id!)} className="bg-blue-500 text-white px-4 py-2 rounded">
                Voir les documents
              </button>
            )}
          </div>
        ))}
      </div>
    </div>
  );
}
