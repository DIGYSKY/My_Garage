import type { Cars } from "./add-cars";

export function FormCars({
  handleSubmit,
  handleChangeBrand,
  handleChangeModel,
  handleChangePrice,
  handleChangeFirstRegistrationDate,
  handleChangeLitleName,
  cars,
}: {
  handleSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
  handleChangeBrand: (e: React.ChangeEvent<HTMLInputElement>) => void;
  handleChangeModel: (e: React.ChangeEvent<HTMLInputElement>) => void;
  handleChangePrice: (e: React.ChangeEvent<HTMLInputElement>) => void;
  handleChangeFirstRegistrationDate: (e: React.ChangeEvent<HTMLInputElement>) => void;
  handleChangeLitleName: (e: React.ChangeEvent<HTMLInputElement>) => void;
  cars: Cars;
}) {
  return (
    <div className="container mx-auto px-4 py-8 max-w-md">
      <form
        action="#"
        method="POST"
        className="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4"
        onSubmit={handleSubmit}
      >
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="brand">
            Marque
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="brand"
            value={cars.brand ?? ""}
            onChange={handleChangeBrand}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="model">
            Modèle
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="model"
            value={cars.model ?? ""}
            onChange={handleChangeModel}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="class">
            Prix
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="number"
            name="price"
            value={cars.price ?? 0}
            onChange={handleChangePrice}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="first_registration_date">
            Date de première mise en circulation
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="date"
            name="first_registration_date"
            value={cars.first_registration_date ?? ""}
            onChange={handleChangeFirstRegistrationDate}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2" htmlFor="litle_name">
            Nom court
          </label>
          <input
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="litle_name"
            value={cars.litle_name ?? ""}
            onChange={handleChangeLitleName}
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