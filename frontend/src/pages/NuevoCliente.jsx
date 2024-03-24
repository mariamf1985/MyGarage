import React, { useState } from 'react';
import Navbar from '../components/molecules/navbar/Navbar';
import Footer from '../components/molecules/footer/Footer';

const NuevoCliente = () => {
    const [cliente, setCliente] = useState({
        nombre: '',
        apellido: '',
        telefono: '',
        email: '',
        coches: [{ marca: '', modelo: '', matricula: '' }],
    });

    const handleClienteChange = (event) => {
        const { name, value } = event.target;
        setCliente({ ...cliente, [name]: value });
    };

    const handleCocheChange = (index, event) => {
        const { name, value } = event.target;
        const newCoches = [...cliente.coches];
        newCoches[index][name] = value;
        setCliente({ ...cliente, coches: newCoches });
    };

    const handleAddCoche = () => {
        setCliente({
            ...cliente,
            coches: [...cliente.coches, { marca: '', modelo: '', matricula: '' }],
        });
    };

    const handleRemoveCoche = (index) => {
        const newCoches = [...cliente.coches];
        newCoches.splice(index, 1);
        setCliente({ ...cliente, coches: newCoches });
    };

    const handleSubmit = async (event) => {
        event.preventDefault();

        try {
            const responseCliente = await fetch('http://127.0.0.1:8000/api/clientes/cliente', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: cliente.nombre,
                    surname: cliente.apellido,
                    phone_number: cliente.telefono,
                    email: cliente.email,
                }),
            });

            if (!responseCliente.ok) {
                throw new Error('Error al guardar el cliente');
            }

            const clienteData = await responseCliente.json();
            const clienteId = clienteData.id;

            for (const coche of cliente.coches) {
                const responseCoche = await fetch('http://127.0.0.1:8000/api/coches/coche', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        brand: coche.marca,
                        model: coche.modelo,
                        registration_plate: coche.matricula,
                        cliente_id: clienteId,
                    }),
                });

                if (!responseCoche.ok) {
                    throw new Error('Error al guardar un coche');
                }
            }

            setCliente({
                nombre: '',
                apellido: '',
                telefono: '',
                email: '',
                coches: [{ marca: '', modelo: '', matricula: '' }],
            });

            alert('Cliente y coches guardados correctamente');
        } catch (error) {
            console.error(error);
            alert('Hubo un error al guardar los datos. Por favor, inténtalo de nuevo.');
        }
    };

    return (
        <>
            <Navbar />
            <div className="max-w-screen-xl mx-auto p-4">
                <h2 className="text-2xl font-bold mb-4">Nuevo Cliente con Coches</h2>
                <form onSubmit={handleSubmit}>
                    <div className="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label htmlFor="nombre" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value={cliente.nombre} onChange={handleClienteChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                        </div>
                        <div>
                            <label htmlFor="apellido" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellido</label>
                            <input type="text" id="apellido" name="apellido" value={cliente.apellido} onChange={handleClienteChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
                        </div>
                        <div>
                            <label htmlFor="telefono" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" value={cliente.telefono} onChange={handleClienteChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" required />
                        </div>
                        <div>
                            <label htmlFor="email" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" id="email" name="email" value={cliente.email} onChange={handleClienteChange} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" />
                        </div>
                    </div>
                    <h3 className="text-lg font-semibold mb-2">Coches</h3>
                    {cliente.coches.map((coche, index) => (
                        <div key={index} className="grid gap-6 mb-6 md:grid-cols-3">
                            <div>
                                <label htmlFor={`marca_${index}`} className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marca</label>
                                <input type="text" id={`marca_${index}`} name="marca" value={coche.marca} onChange={(e) => handleCocheChange(index, e)} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                            </div>
                            <div>
                                <label htmlFor={`modelo_${index}`} className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Modelo</label>
                                <input type="text" id={`modelo_${index}`} name="modelo" value={coche.modelo} onChange={(e) => handleCocheChange(index, e)} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                            </div>
                            <div>
                                <label htmlFor={`matricula_${index}`} className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Matrícula</label>
                                <input type="text" id={`matricula_${index}`} name="matricula" value={coche.matricula} onChange={(e) => handleCocheChange(index, e)} className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                            </div>
                            
                        </div>
                    ))}
                    <button type="submit" className="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Guardar</button>
                </form>
            </div>
            <Footer />
        </>
    );

};

export default NuevoCliente;
