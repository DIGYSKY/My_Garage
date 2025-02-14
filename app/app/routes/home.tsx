import type { Route } from "../+types/home";

export function meta(args: Route["MetaArgs"]) {
  return [
    { title: "Accueil" },
  ];
}

export default function Home() {
  return <div>Home</div>;
}
