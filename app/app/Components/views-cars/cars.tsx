import { useEffect, useState } from "react";
import type { Cars } from "../form-cars/add-cars";
import axios from "axios";

export function Cars() {
  const [cars, setCars] = useState<Cars[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<Error | null>(null);

  useEffect(() => {
    const fetchPersos = async () => {
      try {
        const response = await axios.get("http://localhost:81/cars/:50/:0");
        setCars(response.data);
        setIsLoading(false);
      } catch (err) {
        setError(err as Error);
        setIsLoading(false);
      }
    };
    fetchPersos();
  }, []);

  if (isLoading) return <div>Chargement...</div>;
  if (error) return <div>Erreur: {error.message}</div>;

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">Liste des Véhicules</h1>
      <div className="grid gap-4">
        {cars.map((car: Cars) => (
          <div key={car.brand} className="p-4 border rounded shadow">
            <h2 className="text-lg font-bold">{car.litle_name}</h2>
            <p className="text-sm text-gray-500">{car.brand}</p>
            <p className="text-sm text-gray-500">{car.model}</p>
            <p className="text-sm text-gray-500">{car.price}</p>
            <p className="text-sm text-gray-500">{car.first_registration_date}</p>
          </div>
        ))}
      </div>
    </div>
  );
}
