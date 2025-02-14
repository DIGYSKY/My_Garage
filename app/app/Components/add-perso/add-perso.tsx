import type { Route } from "../../+types/home";
import { useNavigate } from "react-router";
import { useState } from "react";
import axios from "axios";

export interface Perso {
  pseudo: string | null;
  title: string | null;
  class: string | null;
  stats: Stats;
}

type Stats = {
  force: number;
  dexterity: number;
  luck: number;
  intelligence: number;
  knowledge: number;
};

type StatKey = keyof Stats;

export function meta(args: Route["MetaArgs"]) {
  return [
    { title: "Add Perso" },
    { name: "description", content: "Ajouter un personnage" },
  ];
}

export function AddPerso() {
  const navigate = useNavigate();

  const classes = [
    {
      name: "Guerrier",
      value: "warrior",
      min: 20,
      max: 30
    },
    {
      name: "Prêtre",
      value: "priest",
      min: 15,
      max: 25
    },
    {
      name: "Démoniste",
      value: "warlock",
      min: 10,
      max: 15
    }
  ];
  let [rangeStats, setRangeStats] = useState({
    min: 10,
    max: 30
  });
  let [perso, setPerso] = useState<Perso>({
    pseudo: "",
    title: "",
    class: "",
    stats: {
      force: 0,
      dexterity: 0,
      luck: 0,
      intelligence: 0,
      knowledge: 0
    }
  });

  const setPersoStats = (perso: Perso, min: number, max: number) => {
    setPerso(perso => {
      const newStats = { ...perso.stats };
      for (const stat in newStats) {
        if (stat in newStats) {
          newStats[stat as StatKey] = getRandomStat(min, max);
        }
      }
      return { ...perso, stats: newStats };
    });
  }

  const getStatsByClass = (perso: Perso) => {
    if (perso.class === null) {
      setRangeStats({ min: 10, max: 30 });
      setPersoStats(perso, 0, 0);
      return;
    };
    const classInfo = classes.find(c => c.value === perso.class);
    const min = classInfo?.min ?? 10;
    const max = classInfo?.max ?? 30;

    setRangeStats({ min, max });
    setPersoStats(perso, min, max);
  };

  const getRandomStat = (min: number, max: number) =>
    Math.floor(Math.random() * (max - min + 1)) + min;

  const handleChangePseudo = (e: React.ChangeEvent<HTMLInputElement>) => {
    setPerso(perso => {
      const newPerso = { ...perso };
      newPerso.pseudo = e.target.value;
      return newPerso;
    });
  };

  const handleChangeTitle = (e: React.ChangeEvent<HTMLInputElement>) => {
    setPerso(perso => {
      const newPerso = { ...perso };
      newPerso.title = e.target.value;
      return newPerso;
    });
  };

  const handleChangeStat = (e: React.ChangeEvent<HTMLInputElement>) => {
    setPerso(perso => {
      const newPerso = { ...perso };
      const statName = e.target.name.replace('stat_', '') as StatKey;
      newPerso.stats[statName] = parseInt(e.target.value);
      return newPerso;
    });
  };

  const handleChangeClass = (e: React.ChangeEvent<HTMLSelectElement>) => {
    setPerso(perso => {
      const newPerso = { ...perso };
      newPerso.class = e.target.value;
      getStatsByClass(newPerso);
      return newPerso;
    });
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    const persoToSend: Perso = perso;
    console.log(persoToSend);
    await axios.post("http://localhost:81/perso/add", persoToSend)
      .then(response => {
        navigate("/perso/list");
      })
      .catch(error => {
        console.error(error);
      });
  };

  return (
    <div className="container mx-auto px-4 py-8 max-w-md">
      <form
        action="#"
        method="POST"
        className="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4"
        onSubmit={handleSubmit}
      >
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="pseudo">
            Pseudo
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="pseudo"
            value={perso.pseudo ?? ""}
            onChange={handleChangePseudo}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="title">
            Titre
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="title"
            value={perso.title ?? ""}
            onChange={handleChangeTitle}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="class">
            Choix de la classe
          </label>
          <select
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="class"
            value={perso.class ?? ""}
            onChange={handleChangeClass}
          >
            <option value="" disabled>Choix de la classe</option>
            {classes.map((c) => (
              <option key={c.value} value={c.value}>{c.name}</option>
            ))}
          </select>
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="stat_force">
            Force
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="number"
            name="stat_force"
            min={rangeStats.min}
            max={rangeStats.max}
            value={perso.stats.force}
            onChange={handleChangeStat}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="stat_dexterity">
            Agilité
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="number"
            name="stat_dexterity"
            min={rangeStats.min}
            max={rangeStats.max}
            value={perso.stats.dexterity}
            onChange={handleChangeStat}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="stat_luck">
            Chance
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="number"
            name="stat_luck"
            min={rangeStats.min}
            max={rangeStats.max}
            value={perso.stats.luck}
            onChange={handleChangeStat}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="stat_intelligence">
            Intelligence
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="number"
            name="stat_intelligence"
            min={rangeStats.min}
            max={rangeStats.max}
            value={perso.stats.intelligence}
            onChange={handleChangeStat}
            required
          />
        </div>
        <div className="mb-6">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="stat_knowledge">
            Sagesse
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="number"
            name="stat_knowledge"
            min={rangeStats.min}
            max={rangeStats.max}
            value={perso.stats.knowledge}
            onChange={handleChangeStat}
            required
          />
        </div>
        <button
          className="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          type="submit"
        >
          Créer
        </button>
      </form>
    </div>
  );
}
