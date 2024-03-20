import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from '../pages/Home';
import Citas from '../pages/Citas';
import NuevaCita from '../pages/NuevaCita';
import Clientes from '../pages/Clientes';


function Router() {
  return (
    <BrowserRouter>
    <Routes>
        <Route path="/" element={<Home/>}></Route>
        <Route path="/citas" element={<Citas/>}></Route>
        <Route path="/nuevaCita" element={<NuevaCita/>}></Route>
        <Route path="/clientes" element={<Clientes/>}></Route>
         
    </Routes>
</BrowserRouter>
  )
}

export default Router