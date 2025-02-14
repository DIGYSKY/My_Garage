import type { Route } from "../../+types/home";
import { AddCars as AddCarsForm } from "../../Components/form-cars/add-cars";

export function meta(args: Route["MetaArgs"]) {
  return [
    { title: "Add Cars" },
    { name: "description", content: "Ajouter un véhicule" },
  ];
}

export default function AddCarsPage() {
  return <AddCarsForm />;
}
