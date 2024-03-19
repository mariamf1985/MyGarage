import React from 'react'
import blackBgLogo from '../../../assets/img/blackBgLogo.png';

const Footer = () => {
  return (
    

<footer class="bg-black shadow dark:bg-gray-900 flex items-center justify-center w-full fixed bottom-0 inset-x-0 p-0 m-0">
    <div class="p-4 md:py-8 text-xs text-white sm:text-center dark:text-gray-400 flex items-center justify-center space-x-0">
        <span>© 2024</span>
        <img src={blackBgLogo} class="h-6" alt="My Garage logo" />
        <span>™. All Rights Reserved.</span>
    </div>
</footer>

  )
}

export default Footer