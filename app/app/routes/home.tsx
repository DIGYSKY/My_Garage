import type { Route } from "../+types/home";
import { useNavigate } from "react-router";

export function meta(args: Route["MetaArgs"]) {
  return [
    { title: "Accueil" },
  ];
}

export default function Home() {
  const navigate = useNavigate();
  return (
    <div className="flex flex-col items-center justify-center h-screen">
      <h1 className="text-2xl font-bold">Home</h1>
      <button className="bg-blue-500 text-white p-2 rounded" onClick={() => navigate("/cars/list")}>Liste des véhicules</button>
    </div>
  );
}
