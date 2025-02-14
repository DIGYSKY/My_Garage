import { UpdateCars as UpdateCarsForm } from "../../Components/form-cars/update-cars";
import type { Route } from "../../+types/home";

export function meta(args: Route["MetaArgs"]) {
  return [
    { title: "Update Cars" },
  ];
}

export default function UpdateCars() {
  return <UpdateCarsForm />;
}
