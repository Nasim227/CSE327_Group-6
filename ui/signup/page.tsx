import Image from "next/image"
import SignupForm from "@/components/signup-form"

export default function SignupPage() {
  return (
    <main className="min-h-screen bg-background flex items-center justify-center px-4">
      <div className="w-full max-w-md">
        {/* Logo */}
        <div className="flex justify-center mb-12">
          <div className="flex items-center justify-center">
            <Image
              src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/CMS%20Logo-a2cVbA4zNiQ8wIWIKqLAlcDQtMzLzb.jpg"
              alt="CMS Logo"
              width={160}
              height={160}
              className="w-40 h-40"
            />
          </div>
        </div>

        {/* Heading and Subheading */}
        <div className="text-center mb-8">
          <h1 className="text-2xl font-bold tracking-tight text-foreground mb-2">CMS SIGNUP</h1>
          <p className="text-foreground/60 text-sm leading-relaxed">
            Start building your perfect wardrobe. Save your sizes, track orders effortlessly, and never miss a new drop.
          </p>
        </div>

        {/* Signup Form */}
        <SignupForm />

        {/* Already have account */}
        <div className="text-center mt-6 text-sm">
          <span className="text-foreground/70">Already have an account? </span>
          <a href="/login" className="font-semibold text-foreground hover:underline">
            Log in
          </a>
        </div>
      </div>
    </main>
  )
}
