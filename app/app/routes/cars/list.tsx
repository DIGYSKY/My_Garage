import { Cars as CarsList } from "../../Components/views-cars/cars";
import type { Route } from "../../+types/home";

export function meta(args: Route["MetaArgs"]) {
  return [
    { title: "Liste des Véhicules" },
  ];
}

export default function ListCarsPage() {
  return <CarsList />;
}
