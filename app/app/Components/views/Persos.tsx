import { useEffect, useState } from "react";
import type { Perso } from "../add-perso/add-perso";
import axios from "axios";

export function Persos() {
  const [persos, setPersos] = useState<Perso[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<Error | null>(null);

  useEffect(() => {
    const fetchPersos = async () => {
      try {
        const response = await axios.get("http://localhost:81/perso/all");
        setPersos(response.data);
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
      <h1 className="text-2xl font-bold mb-4">Liste des Personnages</h1>
      <div className="grid gap-4">
        {persos.map((perso: Perso) => (
          <div key={perso.pseudo} className="p-4 border rounded shadow">
            <h2 className="font-bold">{perso.pseudo}</h2>
            {/* Ajoutez d'autres champs de Perso selon votre modèle */}
          </div>
        ))}
      </div>
    </div>
  );
}
