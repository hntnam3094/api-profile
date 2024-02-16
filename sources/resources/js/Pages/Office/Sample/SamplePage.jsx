import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm, Controller } from "react-hook-form";
import { Button } from "flowbite-react";
import HasLink from "../Components/HasLink";

export default function SamplePage({ data, form }) {
    const {
        register,
        handleSubmit,
        watch,
        control,
        unregister,
        formState: { errors },
    } = useForm();

    function onSubmit(dataForm) {
        console.log(dataForm);
    }
    form.forEach((element) => {
        console.log(element.name, " :", watch(element.name));
    });

    return (
        <OfficeLayout>
            {
                <form onSubmit={handleSubmit(onSubmit)}>
                    <FormGeneration
                        form={form}
                        register={register}
                        watch={watch}
                        control={control}
                        Controller={Controller}
                        errors={errors}
                        unregister={unregister}
                    />

                    <div className="flex gap-5">
                        <Button type="submit">Submit</Button>
                        <HasLink link="#" color="bg-yellow-400">
                            Back
                        </HasLink>
                    </div>
                </form>
            }
        </OfficeLayout>
    );
}
