import { useEffect, useState } from "react";
import type { Cars } from "../form-cars/add-cars";
import axios from "axios";
import { useParams, useNavigate } from "react-router";

export function Car() {
  const [car, setCar] = useState<Cars | null>(null);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<Error | null>(null);
  const { id } = useParams();
  const navigate = useNavigate();

  const handleDelete = async () => {
    try {
      await axios.delete(`http://localhost:81/cars/:${id}`);
      console.log("Véhicule supprimé avec succès");
      navigate("/cars/list");
    } catch (error) {
      console.error(error);
      setError(error as Error);
    }
  };

  const handleUpdate = () => {
    navigate(`/cars/update/${id}`);
  };

  useEffect(() => {
    console.log(id);
    if (!id) return;

    const fetchCar = async () => {
      try {
        const response = await axios.get(`http://localhost:81/cars/:${id}`);
        if (response.data && response.data.data) {
          setCar(response.data.data);
        } else {
          throw new Error("Données invalides reçues du serveur");
        }
        setIsLoading(false);
      } catch (err: unknown) {
        if (err instanceof Error) {
          setError(err);
        } else {
          setError(new Error("Une erreur inconnue est survenue"));
        }
        setIsLoading(false);
      }
    };
    fetchCar();
  }, [id]);

  if (isLoading) return <div>Chargement...</div>;
  if (error) return <div>Erreur: {error.message}</div>;
  if (!car) return <div>Véhicule non trouvé</div>;

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">Détails du Véhicule</h1>
      <div className="p-4 border rounded shadow">
        <h2 className="text-lg font-bold">{car.litle_name}</h2>
        <p className="text-sm text-gray-500">Marque: {car.brand}</p>
        <p className="text-sm text-gray-500">Modèle: {car.model}</p>
        <p className="text-sm text-gray-500">Prix: {car.price} €</p>
        <p className="text-sm text-gray-500">Date d'immatriculation: {car.first_registration_date}</p>
        <div className="mt-4 space-x-2">
          <button
            className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            onClick={handleUpdate}
          >
            Modifier
          </button>
          <button
            className="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            onClick={handleDelete}
          >
            Supprimer
          </button>
        </div>
      </div>
    </div>
  );
}
