"use client"

import type React from "react"

import { useState } from "react"
import { Eye, EyeOff } from "lucide-react"

export default function GymsharkLogin() {
  const [email, setEmail] = useState("")
  const [password, setPassword] = useState("")
  const [showPassword, setShowPassword] = useState(false)
  const [rememberMe, setRememberMe] = useState(false)

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault()
    console.log("Login attempt:", { email, password, rememberMe })
  }

  return (
    <div className="min-h-screen bg-white flex items-center justify-center px-4">
      <div className="w-full max-w-md">
        {/* Logo */}
        <div className="flex justify-center mb-2">
          <div className="bg-white p-8 rounded-lg flex items-center justify-center">
            <img src="/csm-logo.png" alt="CSM Logo" style={{ width: "160px", height: "auto" }} />
          </div>
        </div>

        {/* Heading */}
        <h1 className="text-center text-2xl font-bold tracking-wide mb-4">CMS LOGIN</h1>

        {/* Tagline */}
        <p className="text-center text-sm text-gray-600 mb-8 leading-relaxed">
          Shop your styles, save top picks to your wishlist,
          <br />
          track those orders & connect with us.
        </p>

        {/* Login Form */}
        <form onSubmit={handleLogin} className="space-y-6">
          {/* Email Input */}
          <div>
            <input
              type="email"
              placeholder="Email address*"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent text-sm"
              required
            />
          </div>

          {/* Password Input */}
          <div className="relative">
            <input
              type={showPassword ? "text" : "password"}
              placeholder="Password*"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent text-sm"
              required
            />
            <button
              type="button"
              onClick={() => setShowPassword(!showPassword)}
              className="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
              aria-label={showPassword ? "Hide password" : "Show password"}
            >
              {showPassword ? <EyeOff className="w-5 h-5" /> : <Eye className="w-5 h-5" />}
            </button>
          </div>

          <div className="flex items-center">
            <input
              type="checkbox"
              id="rememberMe"
              checked={rememberMe}
              onChange={(e) => setRememberMe(e.target.checked)}
              className="w-4 h-4 border border-gray-300 rounded focus:ring-2 focus:ring-black cursor-pointer"
            />
            <label htmlFor="rememberMe" className="ml-2 text-sm text-gray-600 cursor-pointer">
              Remember me
            </label>
          </div>

          {/* Forgot Password Link */}
          <div className="text-center">
            <a href="#" className="text-sm text-black font-semibold underline hover:no-underline transition-all">
              Forgot password?
            </a>
          </div>

          {/* Login Button */}
          <button
            type="submit"
            className="w-full bg-black text-white py-3 rounded-full font-bold text-center hover:bg-gray-900 transition-colors"
          >
            LOG IN
          </button>
        </form>

        {/* Sign Up Link */}
        <p className="text-center text-sm mt-6">
          Don't have an account?{" "}
          <a href="#" className="font-semibold text-black underline hover:no-underline transition-all">
            Sign up
          </a>
        </p>
      </div>
    </div>
  )
}
