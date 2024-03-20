import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Navbar from '../components/molecules/navbar/Navbar';
import Footer from '../components/molecules/footer/Footer';

const Citas = () => {
    const [citas, setCitas] = useState([]);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchCitas = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/citas');
                setCitas(response.data);
            } catch (error) {
                console.error('Error al obtener las citas:', error);
                setError('Error al cargar las citas. Por favor, inténtalo de nuevo más tarde.');
            }
        };

        fetchCitas();
    }, []);

    return (
        <>
            <Navbar />

            <div className="max-w-screen-xl mx-auto p-4">
                <h2 className="text-2xl font-bold mb-4">Lista de Citas</h2>
                {error && <p className="text-red-500">{error}</p>}
                <ul>
                    {citas && citas.map((cita) => {
                        console.log(cita); // Agrega este console.log para verificar los datos de cada cita
                        return (
                            <li key={cita.id} className="mb-6">
                                <h3 className="text-lg font-semibold mb-1">{cita.date}</h3>
                                <p className="text-sm text-gray-500 mb-1">Coche: {cita.id_car}</p>
                                <p className="text-sm text-gray-500">Servicio: {cita.id_service}</p>
                                <p className="text-sm text-gray-500">Descripción: {cita.description}</p>
                            </li>
                        );
                    })}
                </ul>
            </div>

            <Footer />
        </>
    );
};

export default Citas;