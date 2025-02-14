import { Cars as CarsList } from "../../Components/views-cars/cars";
import type { Route } from "../../+types/home";
import { useNavigate } from "react-router";

export function meta(args: Route["MetaArgs"]) {
  return [
    { title: "Liste des Véhicules" },
  ];
}

export default function ListCarsPage() {
  const navigate = useNavigate();
  return (
    <div>
      <h1 className="text-2xl font-bold">Liste des Véhicules</h1>
      <button className="bg-blue-500 text-white p-2 rounded" onClick={() => navigate("/cars/add")}>Ajouter un véhicule</button>
      <CarsList />
    </div>
  );
}
