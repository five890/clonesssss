import { useState } from "react"

export const RegisterPage = () => {
    const [username, setUsername] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    const handleRegister = () => {
        // Lógica de registro aqui
        console.log("Registrando...");
    }

    return (
        <div className="flex flex-col items-center justify-center w-full h-screen bg-[#08080a] text-white px-4">
            <div className="flex flex-col justify-center rounded-xl w-full max-w-md bg-[#121216] border border-[#22222a] p-8 shadow-2xl gap-5">
                
                <div className="flex flex-col gap-1 text-center">
                    <h1 className="text-2xl font-bold tracking-tight text-white">Criar Conta</h1>
                    <p className="text-sm text-zinc-400">Registre-se no painel de revenda</p>
                </div>

                <div className="flex flex-col gap-4 mt-2">
                    <div className="flex flex-col gap-1.5">
                        <label className="text-xs font-medium text-zinc-300">Usuário</label>
                        <input 
                            value={username} 
                            onChange={e => setUsername(e.currentTarget.value)} 
                            type="text" 
                            placeholder="seu_usuario" 
                            className="w-full bg-[#18181d] border border-[#2a2a33] rounded-lg p-3 text-white placeholder-zinc-500 focus:outline-none focus:border-purple-600 text-sm transition-colors" 
                        />
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <label className="text-xs font-medium text-zinc-300">E-mail</label>
                        <input 
                            value={email} 
                            onChange={e => setEmail(e.currentTarget.value)} 
                            type="email" 
                            placeholder="seu@email.com" 
                            className="w-full bg-[#18181d] border border-[#2a2a33] rounded-lg p-3 text-white placeholder-zinc-500 focus:outline-none focus:border-purple-600 text-sm transition-colors" 
                        />
                    </div>

                    <div className="flex flex-col gap-1.5">
                        <label className="text-xs font-medium text-zinc-300">Senha</label>
                        <input 
                            value={password} 
                            onChange={e => setPassword(e.currentTarget.value)} 
                            type="password" 
                            placeholder="••••••••" 
                            className="w-full bg-[#18181d] border border-[#2a2a33] rounded-lg p-3 text-white placeholder-zinc-500 focus:outline-none focus:border-purple-600 text-sm transition-colors" 
                        />
                    </div>

                    <button 
                        onClick={handleRegister} 
                        className="w-full mt-2 rounded-lg bg-[#7c3aed] hover:bg-[#6d28d9] font-medium text-sm py-3 text-white transition-all shadow-lg shadow-purple-900/30"
                    >
                        Criar Conta
                    </button>
                </div>

                <div className="flex justify-center items-center mt-2 text-sm text-zinc-400">
                    <span>Já tem uma conta?&nbsp;</span>
                    <a href="/login" className="text-purple-400 hover:text-purple-300 hover:underline font-medium">Entrar</a>
                </div>
            </div>
        </div>
    );
}
